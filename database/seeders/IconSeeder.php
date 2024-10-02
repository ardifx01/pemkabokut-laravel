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
                'image' => 'uploads/icons/public-service.png' // Gambar lokal
            ],
            [
                'title' => 'Pelayanan Masyarakat',
                'image' => 'uploads/icons/social-services.png' // Gambar lokal
            ],
            [
                'title' => 'Pelayanan Pajak',
                'image' => 'uploads/icons/tax.png' // Gambar lokal
            ],
            [
                'title' => 'Pengaduan Masyarakat',
                'image' => 'uploads/icons/complaint.png' // Gambar lokal
            ],
            [
                'title' => 'Transparansi Anggaran',
                'image' => 'uploads/icons/calculation.png' // Gambar lokal
            ],
            [
                'title' => 'Destinasi Wisata',
                'image' => 'uploads/icons/destination.png' // Gambar lokal
            ],
            [
                'title' => 'Produk Hukum',
                'image' => 'uploads/icons/law-book.png' // Gambar lokal
            ]
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}
