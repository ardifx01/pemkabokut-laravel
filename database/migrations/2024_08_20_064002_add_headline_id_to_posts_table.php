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
        Schema::table('posts', function (Blueprint $table) {
            // Menambahkan kolom headline_id
            $table->unsignedBigInteger('headline_id')->after('id')->nullable();

            // Menambahkan foreign key constraint
            $table->foreign('headline_id')->references('id')->on('headlines')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['headline_id']);

            // Menghapus kolom headline_id
            $table->dropColumn('headline_id');
        });
    }
};
