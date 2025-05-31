<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMedia extends Model
{
    protected $table = 'event_media';
    protected $fillable = [
        'event_id',
        'uploader_id',
        'type',
        'url',
        'file_name',
        'mime_type',
        'size',
        'description',
        'thumbnail_url',
        'duration'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
