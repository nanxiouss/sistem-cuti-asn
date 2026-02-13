<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT SITI DULU (ID 5)
        User::updateOrCreate(
            ['nip' => '199107042024211016'],
            [
                'id' => 5, // ID ini harus ada duluan
                'nama' => 'Siti Aminah',
                'password' => Hash::make('123456'),
                'jabatan' => 'Kasi Listrik',
                'unit_kerja' => 'Seksi Listrik',
                'masa_kerja_tahun' => 18,
                'masa_kerja_bulan' => 3,
                'role' => 'kasi',
                'id_atasan' => null, // Kasi tidak punya atasan di tabel ini
            ]
        );

        // 2. BARU BUAT BAMBANG (ID 1)
        User::updateOrCreate(
            ['nip' => '198501012010011001'],
            [
                'id' => 1,
                'nama' => 'Bambang Pamungkas',
                'password' => Hash::make('123456'),
                'jabatan' => 'Analisis Kelistrikan',
                'unit_kerja' => 'Bidang Ketenagalistrikan',
                'masa_kerja_tahun' => 12,
                'masa_kerja_bulan' => 5,
                'role' => 'pelaksana',
                'id_atasan' => 5, // Aman, karena ID 5 sudah dibuat di atas
            ]
        );
    }
}
