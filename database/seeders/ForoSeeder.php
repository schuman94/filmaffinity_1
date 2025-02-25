<?php

namespace Database\Seeders;

use App\Models\Foro;
use App\Models\Pelicula;
use App\Models\Videojuego;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un foro por cada película
        Pelicula::all()->each(function ($pelicula) {
            Foro::factory()->create([
                'forable_id' => $pelicula->id,
                'forable_type' => Pelicula::class,
            ]);
        });

        // Crear un foro por cada videojuego
        Videojuego::all()->each(function ($videojuego) {
            Foro::factory()->create([
                'forable_id' => $videojuego->id,
                'forable_type' => Videojuego::class,
            ]);
        });
    }
}
