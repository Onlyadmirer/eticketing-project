<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'akmalrbc6@gmail.com', 
            'password' => Hash::make('passwordAdmin'), 
            'role' => 'admin', 
            'organizer_status' => 'approved', 
        ]);
    }
}