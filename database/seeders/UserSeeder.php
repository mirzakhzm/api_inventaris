<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '081234567890',
            'role' => 'pegawai',
            'password' => Hash::make('testpassword123'),
            'token' => 'test'
        ]);
    }
}
