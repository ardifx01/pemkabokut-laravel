<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            ['title' => 'Rencana Umum Pengadaan', 'data_id' => 1],
            ['title' => 'Umum', 'data_id' => 2],
            ['title' => 'LKPD 2019 Kabupaten OKU Timur', 'data_id' => 2],
            ['title' => 'Data Umum', 'data_id' => 3],
            ['title' => 'Perencanaan Daerah', 'data_id' => 4],
            ['title' => 'PK KABUPATEN OKU TIMUR', 'data_id' => 4],
            ['title' => 'LKPJ KABUPTEN OKU TIMUR', 'data_id' => 5],
            ['title' => 'RPJMD KABUPATEN OKU TIMUR', 'data_id' => 5],
            ['title' => 'RKPD KABUPATEN OKU TIMUR', 'data_id' => 5],
            ['title' => 'KUA PPAS BAPPEDA OKU TIMUR', 'data_id' => 5],
            ['title' => 'Keuangan Daerah', 'data_id' => 5],
            ['title' => 'REKAP DEPAN DPA 2022', 'data_id' => 5],
            ['title' => 'KEBIJAKAN AKUNTANSI', 'data_id' => 5],
            ['title' => 'SK PPKD', 'data_id' => 5],
            ['title' => 'RINGKASAN DPA PPKD', 'data_id' => 5],
            ['title' => 'RINGKASAN RKA APBD', 'data_id' => 5],
            ['title' => 'RINGKASAN RKA SKPD', 'data_id' => 5],
            ['title' => 'REALISASI BELANJA DAERAH', 'data_id' => 5],
            ['title' => 'REALISASI PEMBIAYAAN DAERAH', 'data_id' => 5],
            ['title' => 'REALISASI PENDAPATAN DAERAH', 'data_id' => 5],
            ['title' => 'PERDA TENTANG KEUANGAN DAERAH', 'data_id' => 5],
            ['title' => 'PERBUB TENTANG KEUANGAN DAERAH', 'data_id' => 5],
            ['title' => 'CALK KABUPATEN OKU TIMUR', 'data_id' => 5],
            ['title' => 'KUPA KABUPATEN OKU TIMUR', 'data_id' => 5],
            ['title' => 'LAPORAN ARUS KAS', 'data_id' => 5],
            ['title' => 'LAPORAN ARUS KAS', 'data_id' => 5],
            ['title' => 'LAPORAN KUANGAN PERUSAHAAN DAERAH', 'data_id' => 5],
            ['title' => 'LAPORAN REALISASI ANGGARAN SKPD', 'data_id' => 5],
            ['title' => 'LRA RKPD', 'data_id' => 5],
            ['title' => 'NERACA', 'data_id' => 5],
            ['title' => 'OPINI BPK', 'data_id' => 5],
            ['title' => 'KUA', 'data_id' => 5],
            ['title' => 'PPAS', 'data_id' => 5],
            ['title' => 'RINGKASAN RKA PPKD', 'data_id' => 5],
            ['title' => 'PERDA NOMOR 5 TAHUN 2020 APBD TAHUN ANGGARAN 2021', 'data_id' => 5],
            ['title' => 'PERDA NOMOR 4 TAHUN 2020 PERUBAHAN APBD TA 2020', 'data_id' => 5],
            ['title' => 'PERDA NO 5 TAHUN 2019 TAHUN ANGGARAN 2020', 'data_id' => 5],
            ['title' => 'LKPD 2019 Kabupaten OKU Timur', 'data_id' => 5],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
