<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Akmal',
            'email' => 'akmalrbc6@gmail.com',
            'password' => Hash::make('adminPass'),
            'role' => 'admin',
        ]);

        // 2. Akun Organizer (Sudah disetujui)
        User::create([
            'name' => 'Event Organizer 1',
            'email' => 'organizer@organizer.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organizer_status' => 'approved',
        ]);
        
        // 3. Akun Organizer (Pending/Belum disetujui - untuk tes fitur approve)
        User::create([
            'name' => 'Event Organizer Baru',
            'email' => 'pending@organizer.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'organizer_status' => 'pending',
        ]);

        // 4. Akun User Biasa
        User::create([
            'name' => 'joni',
            'email' => 'joni@yopmail.com',
            'password' => Hash::make('joni123456'),
            'role' => 'user',
        ]);
    }
}