<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateEvent extends Model
{
    protected $fillable = [
        'event_id',
        'organization_name',
        'event_theme'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function sponsors()
    {
        return $this->hasMany(CorporateEventSponsor::class);
    }
    public function speakers()
    {
        return $this->hasMany(CorporateEventSpeaker::class);
    }
}
