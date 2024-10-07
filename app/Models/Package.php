<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'package_id',
        'package_name',
        'storage_description',
        'upload_time_description',
        'upload_time_days',  // Gün cinsinden upload time
        'storage_time_description',
        'storage_time_days',  // Gün cinsinden storage time
        'price',
        'background_color',
        'box_bg',
    ];
}
