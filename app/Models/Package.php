<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'price',
        'months',
        'storage',
        'recommended',
        'description',
    ];

    public function features()
    {
        return $this->hasMany(PackageFeature::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_package')->withPivot(['recommended', 'description'])->withTimestamps();
    }
}
