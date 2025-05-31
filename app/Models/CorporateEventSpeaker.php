<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateEventSpeaker extends Model
{
    protected $fillable = [
        'corporate_event_id', 'speaker_name'
    ];
    public function corporateEvent()
    {
        return $this->belongsTo(CorporateEvent::class);
    }
} 