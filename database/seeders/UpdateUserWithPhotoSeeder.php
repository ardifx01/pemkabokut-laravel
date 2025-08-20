<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserWithPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update atau buat user admin dengan foto
        $admin = User::updateOrCreate(
            ['email' => 'admin@okutimur.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'foto' => 'admin-avatar.png' // File foto default admin
            ]
        );

        // Jika ada user lain, bisa ditambahkan di sini
        $user1 = User::updateOrCreate(
            ['email' => 'hizrian@okutimur.com'],
            [
                'name' => 'Hizrian',
                'password' => Hash::make('password'),
                'foto' => 'hizrian-avatar.png'
            ]
        );

        $this->command->info('Users dengan foto berhasil dibuat/diupdate!');
    }
}
