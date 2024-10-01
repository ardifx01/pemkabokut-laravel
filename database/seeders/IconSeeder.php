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
                'image' => 'icons/portal/public-service.png' // Gambar lokal
            ],
            [
                'title' => 'Pelayanan Masyarakat',
                'image' => 'icons/portal/social-services.png' // Gambar lokal
            ],
            [
                'title' => 'Pelayanan Pajak',
                'image' => 'icons/portal/tax.png' // Gambar lokal
            ],
            [
                'title' => 'Pengaduan Masyarakat',
                'image' => 'icons/portal/porcomplaint.png' // Gambar lokal
            ],
            [
                'title' => 'Transparansi Anggaran',
                'image' => 'icons/portal/calculation.png' // Gambar lokal
            ],
            [
                'title' => 'Destinasi Wisata',
                'image' => 'icons/portal/destination.png' // Gambar lokal
            ],
            [
                'title' => 'Produk Hukum',
                'image' => 'icons/portal/law-book.png' // Gambar lokal
            ]
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}
