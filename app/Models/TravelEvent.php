<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelEvent extends Model
{
    protected $fillable = [
        'event_id', 'trip_type', 'surprise_planned', 'partner_name', 'destination_name'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
} 