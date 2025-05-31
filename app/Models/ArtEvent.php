<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtEvent extends Model
{
    protected $fillable = [
        'event_id', 'artist_or_group_name', 'performance_type', 'ticket_required'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
} 