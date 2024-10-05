<?php

namespace Database\Seeders;

use App\Models\Dropdown;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dropdowns = [
            [
                'title' => 'Dinas Pendidikan dan Kebudayaan',
                'link' => 'https://disdikbud.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Sosial',
                'link' => 'https://dinsos.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Tenaga Kerja  dan Transmigrasi',
                'link' => 'https://sikuning.okutimurkab.co.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'link' => 'http://dukcapil.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Koperasi, Usaha Kecil dan Menengah',
                'link' => 'https://dinkopukmokut.com/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                'link' => 'https://dpmptsp.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Badan Perencanaan Pembangunan Daerah dan Litbang',
                'link' => 'https://bappedalitbang.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Badan Kepegawaian Dan Pengembangan Sumber Daya Manusia',
                'link' => 'https://bkpsdm.okutimurkab.go.id/',
                'icon_id' => '6'
            ],
            [
                'title' => 'Desa Cinta Statistik Terintegrasi',
                'link' => 'https://sidomulyo-belitang.my.id/',
                'icon_id' => '7'
            ],
            [
                'title' => 'Badan Pusat Statistik Kabupaten Ogan Komering Ulu Timur',
                'link' => 'https://okutimurkab.bps.go.id/id',
                'icon_id' => '8'
            ],
        ];

        foreach ($dropdowns as $dropdown) {
            Dropdown::create($dropdown);
        }
    }
}
