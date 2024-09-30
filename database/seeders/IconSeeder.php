<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            [
                'title' => 'Pelayanan Kependudukan',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/public-service.png'
            ],
            [
                'title' => 'Pelayanan Masyarakat',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/social-services.png'
            ],
            [
                'title' => 'Pelayanan Pajak',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/tax.png'
            ],
            [
                'title' => 'Pengaduan Masyarakat',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/complaint.png'
            ],
            [
                'title' => 'Transparansi Anggaran',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/calculation.png'
            ],
            [
                'title' => 'Destinasi Wisata',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/destination.png'
            ],
            [
                'title' => 'Produk Hukum',
                'image' => 'https://bandungbaratkab.go.id/img/icons2/law-book.png'
            ]
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}
