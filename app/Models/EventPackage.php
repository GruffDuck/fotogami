<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPackage extends Pivot
{
    protected $table = 'event_package';
    protected $fillable = [
        'event_id', 'package_id', 'recommended', 'description'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
} 