<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        DB::table('packages')->insert([
            [
                'package_id' => '1',
                'package_name' => 'Starter',
                'storage_description' => '3GB Storage',
                'upload_time_description' => '3 days upload time',
                'upload_time_days' => 3,  // 3 gün
                'storage_time_description' => '3 month storage time',
                'storage_time_days' => 90,  // 3 ay yaklaşık 90 gün
                'price' => '1250₺',
                'background_color' => '#f48fb1',
                'box_bg' => '#FDE4E6',
            ],
            [
                'package_id' => '2',
                'package_name' => 'Standard',
                'storage_description' => '5GB Storage',
                'upload_time_description' => '1 week upload time',
                'upload_time_days' => 7,  // 7 gün
                'storage_time_description' => '6 month storage time',
                'storage_time_days' => 180,  // 6 ay yaklaşık 180 gün
                'price' => '2000₺',
                'background_color' => '#2979FF',
                'box_bg' => '#E5F2FE',
            ],
            [
                'package_id' => '3',
                'package_name' => 'Mega',
                'storage_description' => '10GB Storage',
                'upload_time_description' => '2 week upload time',
                'upload_time_days' => 14,  // 14 gün
                'storage_time_description' => '1 year storage time',
                'storage_time_days' => 365,  // 1 yıl 365 gün
                'price' => '3000₺',
                'background_color' => '#FF6F61',
                'box_bg' => '#FDEDEB',
            ],
            [
                'package_id' => '4',
                'package_name' => 'Premium',
                'storage_description' => 'Unlimited storage',
                'upload_time_description' => '1 month upload time',
                'upload_time_days' => 30,  // 1 ay yaklaşık 30 gün
                'storage_time_description' => '2 year storage time',
                'storage_time_days' => 730,  // 2 yıl 730 gün
                'price' => '5000₺',
                'background_color' => '#424242',
                'box_bg' => '#EEEEEE',
            ],
        ]);
    }
}
