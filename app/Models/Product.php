<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'organization_name',
        'organization_type',
        'bride_name',
        'groom_name',
        'date',
        'location',
        'folder_name',
        'freeSpace',
        'fullSpace',
        'usedSpace'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
