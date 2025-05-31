<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateEventSponsor extends Model
{
    protected $fillable = [
        'corporate_event_id', 'sponsor_name'
    ];
    public function corporateEvent()
    {
        return $this->belongsTo(CorporateEvent::class);
    }
} 