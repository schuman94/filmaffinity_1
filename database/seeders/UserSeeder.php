<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin'),
        ]);

        User::create([
            'name' => 'Sergio',
            'email' => 'sergio@sergio.com',
            'password' => Hash::make('sergiosergio'),
        ]);

        User::create([
            'name' => 'Pepe',
            'email' => 'pepe@pepe.com',
            'password' => Hash::make('pepepepe'),
        ]);
    }
}
