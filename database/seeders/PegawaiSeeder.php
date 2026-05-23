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
        $sekdin = User::where('nip', '12345678')->first();
        $kasubbag_umum = User::where('nip', '55555555')->first();
        $kabid = User::where('nip', '22222222')->first();
        $kabid1 = User::where('nip', '21212121')->first();
        $kasi = User::where('nip', '33333333')->first();
        $kasi1 = User::where('nip', '31313131')->first();
        $admin = User::where('nip', '99999999')->first();
        $pegawai = User::where('nip', '44444444')->first();
        $pegawai1 = User::where('nip', '41414141')->first();

        // Pastikan datanya ketemu sebelum membuat Pegawai
        if($kadin && $sekdin && $kabid && $kasi && $admin && $pegawai) {
            
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

            // Sekdin (Atasan: Kadin)
            Pegawai::create([
                'user_id' => $sekdin->id,
                'atasan_id' => $kadin->id,
                'pangkat_golongan' => 'Sekretaris / III.d',
                'jabatan' => 'Sekretaris Dinas', 
                'unit_kerja' => 'Sekretaris Dinas',
                'tmt_kerja' => '2016-05-25',
                'sisa_cuti_tahunan' => 12
            ]);

            // Kasubbag_umum (Atasan: Admin)
            Pegawai::create([
                'user_id' => $kasubbag_umum->id,
                'atasan_id' => $sekdin->id,
                'pangkat_golongan' => 'Pembina / IV.a',
                'jabatan' => 'Kepala Subbag Umum & Kepegawaian',
                'unit_kerja' => 'Subbag Umum & Kepegawaian',
                'tmt_kerja' => '2014-09-19',
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

            Pegawai::create([
                'user_id' => $kabid1->id,
                'atasan_id' => $kadin->id,
                'pangkat_golongan' => 'Pembina / IV.a',
                'jabatan' => 'Kepala Bidang UPTD LAB',
                'unit_kerja' => 'Bidang UPTD LAB',
                'tmt_kerja' => '2016-03-15',
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

            Pegawai::create([
                'user_id' => $kasi1->id,
                'atasan_id' => $kabid->id,
                'pangkat_golongan' => 'Penata / III.c',
                'jabatan' => 'Kepala Subbag Tata Usaha',
                'unit_kerja' => 'Subbag Tata Usaha',
                'tmt_kerja' => '2016-03-21',
                'sisa_cuti_tahunan' => 12
            ]);

            // Admin (Atasan: Kasubbag_umum)
            Pegawai::create([
                'user_id' => $admin->id,
                'atasan_id' => $kasubbag_umum->id,
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

            Pegawai::create([
                'user_id' => $pegawai1->id,
                'atasan_id' => $kasi->id,
                'pangkat_golongan' => 'Pengatur Tingkat I / II.d',
                'jabatan' => 'Staf Tata Usaha',
                'unit_kerja' => 'Subbag Tata Usaha',
                'tmt_kerja' => '2019-05-19',
                'no_telepon' => '0895642355498',
                'sisa_cuti_tahunan' => 12
            ]);
        }
    }
}
