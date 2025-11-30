<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            EventSeeder::class,
            SecondOrganizerSeeder::class,
        ]);

        // 1. Akun Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
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
        
        // 3. Akun Organizer 
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
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}