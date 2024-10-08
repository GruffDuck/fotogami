<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
        'usedSpace',
        'email', // Yeni alan
        'phone', // Yeni alan
        'guests_count', // guests_count alanı eklendi
        'description'    // description alanı eklendi


    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
