<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
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
    ];

    public function wedding()
    {
        return $this->hasOne(WeddingEvent::class);
    }
    public function graduation()
    {
        return $this->hasOne(GraduationEvent::class);
    }
    public function corporate()
    {
        return $this->hasOne(CorporateEvent::class);
    }
    public function art()
    {
        return $this->hasOne(ArtEvent::class);
    }
    public function travel()
    {
        return $this->hasOne(TravelEvent::class);
    }
    public function media()
    {
        return $this->hasMany(EventMedia::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'event_package')->withPivot(['recommended', 'description'])->withTimestamps();
    }
}
