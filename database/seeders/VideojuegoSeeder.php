<?php

namespace Database\Seeders;

use App\Models\Videojuego;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideojuegoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Videojuego::factory()->count(100)->create();
    }
}
