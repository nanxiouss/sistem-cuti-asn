<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Pak Bambang Pamungkas
        User::updateOrCreate(
            ['nip' => '198501012010011001'], // Kunci pengecekan (biar tidak duplikat)
            [
                'id' => 1, // Memaksa ID menjadi 1
                'nama' => 'Bambang Pamungkas',
                'password' => Hash::make('123456'), // Password di-hash (sangat penting!)
                'jabatan' => 'Analisis Kelistrikan',
                'unit_kerja' => 'Bidang Ketenagalistrikan',
                'masa_kerja_tahun' => 12,
                'masa_kerja_bulan' => 5,
                'role' => 'pelaksana',

                // PERHATIAN:
                // Jika User dengan ID 5 belum ada di database, baris di bawah ini akan error.
                // Jika error, ganti '5' menjadi null dulu.
                'id_atasan' => null,
            ]
        );
    }
}
