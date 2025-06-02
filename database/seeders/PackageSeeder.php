<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packagesData = [
            [
                'id' => 1,
                'name' => 'Mini Paket',
                'price' => 99,
                'months' => 3,
                'storage' => 1,
                'recommended' => false,
                'description' => '1 kişilik küçük etkinlikler için uygundur.',
                'features' => ['Fotoğraf', 'Online Albüm'],
            ],
            [
                'id' => 2,
                'name' => 'Başlangıç Paketi',
                'price' => 199,
                'months' => 6,
                'storage' => 5,
                'recommended' => false,
                'description' => '5 kişiye kadar küçük gruplar için.',
                'features' => ['Fotoğraf', 'Video', 'Online Albüm'],
            ],
            [
                'id' => 3,
                'name' => 'Standart Paket',
                'price' => 399,
                'months' => 12,
                'storage' => 15,
                'recommended' => false,
                'description' => '15 kişiye kadar etkinlikler için ideal.',
                'features' => [
                    'Fotoğraf',
                    'Video',
                    'Slayt Gösterisi',
                    'Online Albüm',
                    'Yüksek Çözünürlük',
                ],
            ],
            [
                'id' => 4,
                'name' => 'Gelişmiş Paket',
                'price' => 699,
                'months' => 24,
                'storage' => 25,
                'recommended' => false,
                'description' => '25 kişiye kadar orta ölçekli etkinlikler için.',
                'features' => [
                    'Fotoğraf',
                    'Video',
                    'Drone Çekimi',
                    'Slayt Gösterisi',
                    'Online Albüm',
                    'Yüksek Çözünürlük',
                ],
            ],
            [
                'id' => 5,
                'name' => 'Pro Paket',
                'price' => 1199,
                'months' => 36,
                'storage' => 50,
                'recommended' => false,
                'description' => '50 kişiye kadar büyük etkinlikler için.',
                'features' => [
                    'Fotoğraf',
                    'Video',
                    'Drone Çekimi',
                    'Canlı Yayın',
                    'Slayt Gösterisi',
                    'Online Albüm',
                    'Yüksek Çözünürlük',
                ],
            ],
            [
                'id' => 6,
                'name' => 'Sınırsız Paket',
                'price' => 1999,
                'months' => 60,
                'storage' => -1,
                'recommended' => false,
                'description' => 'Sınırsız katılımcı ve depolama ile en kapsamlı paket.',
                'features' => [
                    'Fotoğraf',
                    'Video',
                    'Drone Çekimi',
                    'Canlı Yayın',
                    'Slayt Gösterisi',
                    'Online Albüm',
                    'Yüksek Çözünürlük',
                    'After Party Çekimi',
                ],
            ],
        ];

        foreach ($packagesData as $package) {
            DB::table('packages')->insert([
                'id' => $package['id'],
                'name' => $package['name'],
                'price' => $package['price'],
                'months' => $package['months'],
                'storage' => $package['storage'],
                'recommended' => $package['recommended'],
                'description' => $package['description'],
            ]);
            foreach ($package['features'] as $feature) {
                DB::table('package_features')->insert([
                    'package_id' => $package['id'],
                    'name' => $feature,
                ]);
            }
        }
    }
}
