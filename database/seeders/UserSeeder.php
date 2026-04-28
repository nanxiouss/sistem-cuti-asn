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
        $kabid = User::create(['nip' => '22222222', 'nama' => 'Bapak Kabid, S.T', 'password' => Hash::make('123456'), 'role' => 'administrator']);
        $kasi = User::create(['nip' => '33333333', 'nama' => 'Bapak Kasi, S.Kom', 'password' => Hash::make('123456'), 'role' => 'kasi']);
        $admin = User::create(['nip' => '99999999', 'nama' => 'Admin Kepegawaian', 'password' => Hash::make('123456'), 'role' => 'admin']);
        $pegawai = User::create(['nip' => '44444444', 'nama' => 'Andi Staf Biasa', 'password' => Hash::make('123456'), 'role' => 'pegawai']);
    }
}
