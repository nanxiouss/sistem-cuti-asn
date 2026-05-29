<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nip' => '99999999', 
            'nama' => 'Admin Kepegawaian', 
            'password' => Hash::make('123456'), 
            'role' => 'admin'
        ]);
    }
}