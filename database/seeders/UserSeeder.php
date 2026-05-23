<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $kadin = User::create(['nip' => '11111111', 'nama' => 'Ir. Bapak Kadin, M.Si', 'password' => Hash::make('123456'), 'role' => 'kadin']);
        $sekdin = User::create(['nip' => '12345678', 'nama' => 'Bapak Sekdin, M.Ti', 'password' => Hash::make('123456'), 'role' => 'sekdin']);
        $kabid = User::create(['nip' => '22222222', 'nama' => 'Bapak Kabid a, S.T', 'password' => Hash::make('123456'), 'role' => 'kabid']);
        $kabid1 = User::create(['nip' => '21212121', 'nama' => 'Bapak Kabid b, S.Mt', 'password' => Hash::make('123456'), 'role' => 'kabid']);
        $kasi = User::create(['nip' => '33333333', 'nama' => 'Bapak Kasi a, S.Kom', 'password' => Hash::make('123456'), 'role' => 'kasi']);
        $kasi1 = User::create(['nip' => '31313131', 'nama' => 'Bapak Kasi b, S.Kom', 'password' => Hash::make('123456'), 'role' => 'kasi']);
        $kasubbag_umum = user::create(['nip' => '55555555', 'nama' => 'Bapak Imam, S.I', 'password' => Hash::make('123456'), 'role' => 'kasubbag_umum']);
        $admin = User::create(['nip' => '99999999', 'nama' => 'Admin Kepegawaian', 'password' => Hash::make('123456'), 'role' => 'admin']);
        $pegawai = User::create(['nip' => '44444444', 'nama' => 'Nia Sahbellah', 'password' => Hash::make('123456'), 'role' => 'pegawai']);
        $pegawai1 = User::create(['nip' => '41414141', 'nama' => 'Shin Hakuro', 'password' => Hash::make('123456'), 'role' => 'pegawai']);
    }
}
