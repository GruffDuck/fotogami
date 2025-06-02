<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\WeddingEvent;
use App\Models\GraduationEvent;
use App\Models\CorporateEvent;
use App\Models\ArtEvent;
use App\Models\TravelEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Tüm eventleri ve ilişkili alt tipleri getir
        $events = Event::with(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages', 'eventPackages'])->get();
        return response()->json($events);
    }

    public function show($id)
    {
        // Tek bir eventi ve ilişkili alt tipleri getir
        $event = Event::with(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages', 'eventPackages'])->findOrFail($id);
        return response()->json($event);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = \App\Models\User::findOrFail($request->input('created_by'));
            // Bireysel kullanıcı ise, aktif event var mı kontrol et
            if ($user->isIndividual()) {
                $activeEvent = $user->events()->first();
                if ($activeEvent) {
                    return response()->json(['error' => 'Bireysel kullanıcı aynı anda birden fazla etkinlik oluşturamaz.'], 403);
                }
            }
            $eventData = $request->only([
                'event_name',
                'date',
                'time',
                'address',
                'latitude',
                'longitude',
                'city',
                'country',
                'expected_guests',
                'is_public_sharing_allowed',
                'media_access_level',
                'notes',
                'created_by',
                'type'
            ]);
            $event = Event::create($eventData);

            // Alt tip tablosuna ekle
            switch ($event->type) {
                case 'wedding':
                    WeddingEvent::create(array_merge($request->only(['bride_name', 'groom_name', 'venue_name', 'photo_package_type']), ['event_id' => $event->id]));
                    break;
                case 'graduation':
                    GraduationEvent::create(array_merge($request->only(['student_name', 'school_name', 'grade_level', 'teacher_name']), ['event_id' => $event->id]));
                    break;
                case 'corporate':
                    $corporate = CorporateEvent::create(array_merge($request->only(['organization_name', 'event_theme']), ['event_id' => $event->id]));
                    // Sponsor ve speaker listeleri
                    if ($request->has('sponsor_list')) {
                        foreach ($request->input('sponsor_list') as $sponsor) {
                            $corporate->sponsors()->create(['sponsor_name' => $sponsor]);
                        }
                    }
                    if ($request->has('speaker_list')) {
                        foreach ($request->input('speaker_list') as $speaker) {
                            $corporate->speakers()->create(['speaker_name' => $speaker]);
                        }
                    }
                    break;
                case 'art':
                    ArtEvent::create(array_merge($request->only(['artist_or_group_name', 'performance_type', 'ticket_required']), ['event_id' => $event->id]));
                    break;
                case 'travel':
                    TravelEvent::create(array_merge($request->only(['trip_type', 'surprise_planned', 'partner_name', 'destination_name']), ['event_id' => $event->id]));
                    break;
            }
            // Paket ekleme kuralı (artık sadece bir paket eklenebilir)
            $package = $request->input('package');
            if (is_array($package) && isset($package['id'])) {
                $event->packages()->attach($package['id'], [
                    'recommended' => $package['recommended'] ?? false,
                    'description' => $package['description'] ?? null
                ]);
            }
            DB::commit();
            return response()->json($event->load(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages.features']), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($id);
            $event->update($request->only([
                'event_name',
                'date',
                'time',
                'address',
                'latitude',
                'longitude',
                'city',
                'country',
                'expected_guests',
                'is_public_sharing_allowed',
                'media_access_level',
                'notes',
                'created_by',
                'type'
            ]));

            // Alt tip güncelle
            switch ($event->type) {
                case 'wedding':
                    $event->wedding?->update($request->only(['bride_name', 'groom_name', 'venue_name', 'photo_package_type']));
                    break;
                case 'graduation':
                    $event->graduation?->update($request->only(['student_name', 'school_name', 'grade_level', 'teacher_name']));
                    break;
                case 'corporate':
                    if ($event->corporate) {
                        $event->corporate->update($request->only(['organization_name', 'event_theme']));
                        $event->corporate->sponsors()->delete();
                        if ($request->has('sponsor_list')) {
                            foreach ($request->input('sponsor_list') as $sponsor) {
                                $event->corporate->sponsors()->create(['sponsor_name' => $sponsor]);
                            }
                        }
                        $event->corporate->speakers()->delete();
                        if ($request->has('speaker_list')) {
                            foreach ($request->input('speaker_list') as $speaker) {
                                $event->corporate->speakers()->create(['speaker_name' => $speaker]);
                            }
                        }
                    }
                    break;
                case 'art':
                    $event->art?->update($request->only(['artist_or_group_name', 'performance_type', 'ticket_required']));
                    break;
                case 'travel':
                    $event->travel?->update($request->only(['trip_type', 'surprise_planned', 'partner_name', 'destination_name']));
                    break;
            }
            // Paket güncelleme
            if ($request->has('package')) {
                $package = $request->input('package');
                $currentPackageIds = $event->packages()->pluck('packages.id')->toArray();
                $newPackageId = $package['id'];
                // Eğer mevcutta farklı bir paket varsa, onu kaldır
                foreach ($currentPackageIds as $packageId) {
                    if ($packageId != $newPackageId) {
                        $event->packages()->detach($packageId);
                        $packageModel = \App\Models\Package::find($packageId);
                        if ($packageModel && $packageModel->events()->count() === 0) {
                            $packageModel->features()->delete();
                            $packageModel->delete();
                        }
                    }
                }
                // Yeni paketi ekle veya güncelle
                $event->packages()->syncWithoutDetaching([$newPackageId => [
                    'recommended' => $package['recommended'] ?? false,
                    'description' => $package['description'] ?? null
                ]]);
            }
            DB::commit();
            return response()->json($event->load(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages.features']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($id);
            $packageIds = $event->packages()->pluck('packages.id')->toArray();
            $event->wedding()?->delete();
            $event->graduation()?->delete();
            if ($event->corporate) {
                $event->corporate->sponsors()->delete();
                $event->corporate->speakers()->delete();
                $event->corporate->delete();
            }
            $event->art()?->delete();
            $event->travel()?->delete();
            $event->packages()->detach();
            $event->delete();
            // Paketleri sil (başka eventte kullanılmayanlar)
            foreach ($packageIds as $packageId) {
                $package = \App\Models\Package::find($packageId);
                if ($package && $package->events()->count() === 0) {
                    $package->features()->delete();
                    $package->delete();
                }
            }
            DB::commit();
            return response()->json(['message' => 'Event ve ilişkili veriler silindi.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Bir kullanıcının oluşturduğu tüm eventleri getir
    public function getUserEvents($userId)
    {
        $events = Event::where('created_by', $userId)->with(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages', 'eventPackages'])->get();
        return response()->json($events);
    }

    // Bir organizasyonun oluşturduğu tüm eventleri getir (organization_name ile)
    public function getOrganizationEvents($organizationName)
    {
        $userIds = \App\Models\User::where('organization_name', $organizationName)->pluck('id');
        $events = Event::whereIn('created_by', $userIds)->with(['wedding', 'graduation', 'corporate.sponsors', 'corporate.speakers', 'art', 'travel', 'media', 'creator', 'packages', 'eventPackages'])->get();
        return response()->json($events);
    }
}
