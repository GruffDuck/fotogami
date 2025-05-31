<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingEvent extends Model
{
    protected $fillable = [
        'event_id', 'bride_name', 'groom_name', 'venue_name', 'photo_package_type'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
} 