<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->enum('jenis', [
                'Makanan dan Minuman',
                'Pakaian dan Aksesoris', 
                'Jasa',
                'Kerajinan Tangan',
                'Elektronik',
                'Kesehatan',
                'Transportasi',
                'Pendidikan',
                'Teknologi'
            ]);
            $table->string('alamat', 255);
            $table->string('nomor_telepon', 15);
            $table->string('email', 255);
            $table->string('nib', 50);
            $table->text('deskripsi');
            $table->json('foto')->nullable(); // untuk menyimpan array gambar dalam format JSON
            $table->tinyInteger('status')->default(0)->comment('0 untuk pending, 1 untuk approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
