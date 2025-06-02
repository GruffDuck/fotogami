<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPackage extends Model
{
    protected $table = 'event_package';
    protected $fillable = [
        'event_id',
        'package_id',
        'recommended',
        'description',
        'created_at',
        'updated_at',
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