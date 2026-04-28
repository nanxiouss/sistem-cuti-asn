<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari user berdasarkan NIP yang sudah dibuat di UserSeeder
        $kadin = User::where('nip', '11111111')->first();
        $kabid = User::where('nip', '22222222')->first();
        $kasi = User::where('nip', '33333333')->first();
        $admin = User::where('nip', '99999999')->first();
        $pegawai = User::where('nip', '44444444')->first();

        // Pastikan datanya ketemu sebelum membuat Pegawai
        if($kadin && $kabid && $kasi && $admin && $pegawai) {
            
            // Kadin (Tidak punya atasan)
            Pegawai::create([
                'user_id' => $kadin->id,
                'atasan_id' => null,
                'pangkat_golongan' => 'Pembina Utama Muda / IV.c',
                'jabatan' => 'Kepala Dinas',
                'unit_kerja' => 'Dinas ABC',
                'tmt_kerja' => '2016-04-05',
                'sisa_cuti_tahunan' => 12
            ]);

            // Kabid (Atasan: Kadin)
            Pegawai::create([
                'user_id' => $kabid->id,
                'atasan_id' => $kadin->id,
                'pangkat_golongan' => 'Pembina / IV.a',
                'jabatan' => 'Kepala Bidang Ketenagalistrikan',
                'unit_kerja' => 'Bidang Ketenagalistrikan',
                'tmt_kerja' => '2017-05-22',
                'sisa_cuti_tahunan' => 12
            ]);

            // Kasi (Atasan: Kabid)
            Pegawai::create([
                'user_id' => $kasi->id,
                'atasan_id' => $kabid->id,
                'pangkat_golongan' => 'Penata / III.c',
                'jabatan' => 'Kepala Seksi Analisis',
                'unit_kerja' => 'Seksi Analisis',
                'tmt_kerja' => '2019-01-12',
                'sisa_cuti_tahunan' => 12
            ]);

            // Admin (Tidak kita set atasannya)
            Pegawai::create([
                'user_id' => $admin->id,
                'atasan_id' => null,
                'pangkat_golongan' => 'Penata Muda / III.a',
                'jabatan' => 'Analis Kepegawaian',
                'unit_kerja' => 'Subbag Umum dan Kepegawaian',
                'tmt_kerja' => '2020-04-05',
                'sisa_cuti_tahunan' => 12
            ]);

            // Pegawai (Atasan: Kasi)
            Pegawai::create([
                'user_id' => $pegawai->id,
                'atasan_id' => $kasi->id,
                'pangkat_golongan' => 'Pengatur Tingkat I / II.d',
                'jabatan' => 'Pelaksana Kelistrikan',
                'unit_kerja' => 'Seksi Analisis',
                'tmt_kerja' => '2020-04-21',
                'no_telepon' => '0895645465498',
                'sisa_cuti_tahunan' => 12
            ]);
        }
    }
}
