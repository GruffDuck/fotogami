<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventMediaController extends Controller
{
    public function index(Request $request)
    {
        // Tüm medya dosyalarını listele
    }

    public function show($id)
    {
        // Tek bir medya dosyasını göster
    }

    public function store(Request $request)
    {
        // Yeni medya dosyası ekle
    }

    public function update(Request $request, $id)
    {
        // Medya dosyasını güncelle
    }

    public function destroy($id)
    {
        // Medya dosyasını sil
    }
} 