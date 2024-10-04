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
                'title' => 'Website OPD',
                'image' => 'uploads/icons/public-service.png' // Gambar lokal
            ],
            [
                'title' => 'Layanan Publik',
                'image' => 'uploads/icons/social-services.png' // Gambar lokal
            ],
            [
                'title' => 'Pelayanan Pajak',
                'image' => 'uploads/icons/tax.png' // Gambar lokal
            ],
            [
                'title' => 'Perizinan',
                'image' => 'uploads/icons/complaint.png' // Gambar lokal
            ],
            [
                'title' => 'Inovasi Daerah',
                'image' => 'uploads/icons/destination.png' // Gambar lokal
            ],
            [
                'title' => 'Pengaduan',
                'image' => 'uploads/icons/law-book.png' // Gambar lokal
            ],
            [
                'title' => 'Administrasi Pemerintah',
                'image' => 'uploads/icons/calculation.png' // Gambar lokal
            ]
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}
