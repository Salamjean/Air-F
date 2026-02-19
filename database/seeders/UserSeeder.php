<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'KADIO',
            'prenom' => 'Kouame Serge',
            'email' => 'sergekadio@gmail.com',
            'contact' => '0711117979',
            'adresse' => 'France, Paris',
            'role' => 'admin',
            'email_verified_at' => now(),
            'profile_picture' => 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
            'password' => Hash::make('KKStechnologies2022@'),
        ]);
       
    }
}
