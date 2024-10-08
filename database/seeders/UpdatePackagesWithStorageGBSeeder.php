<?php

namespace Database\Seeders;

// database/seeders/UpdatePackagesWithStorageGBSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Package;

class UpdatePackagesWithStorageGBSeeder extends Seeder
{
    public function run()
    {
        Package::where('package_name', 'Starter')->update(['storage_gb' => 3]);
        Package::where('package_name', 'Standard')->update(['storage_gb' => 5]);
        Package::where('package_name', 'Mega')->update(['storage_gb' => 10]);
        Package::where('package_name', 'Premium')->update(['storage_gb' => null]); // Sınırsız olduğu için null
    }
}
