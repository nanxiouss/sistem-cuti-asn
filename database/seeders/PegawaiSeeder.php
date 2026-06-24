<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('nip', '99999999')->first();

        if ($admin) {
            Pegawai::create([
                'user_id' => $admin->id,
                'atasan_id' => null,
                'bidang_id' => 1,
                'pangkat_id' => 6,
                'jabatan' => 'Analis Kepegawaian',
                'masa_kerja' => '2020-04-05',
                'sisa_cuti_tahunan' => 12
            ]);
        }
    }
}