<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Genero;
use App\Models\Pelicula;
use App\Models\Videojuego;

class GeneroableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $generos = Genero::pluck('id'); // Obtiene los IDs de los géneros
        $peliculas = Pelicula::pluck('id'); // Obtiene los IDs de las películas
        $videojuegos = Videojuego::pluck('id'); // Obtiene los IDs de los videojuegos

        // Asignar géneros a películas
        foreach ($peliculas as $pelicula_id) {
            $numGeneros = rand(1, 3); // Asigna entre 1 y 3 géneros
            $generosSeleccionados = $generos->random($numGeneros);

            foreach ($generosSeleccionados as $genero_id) {
                DB::table('generoables')->insert([
                    'genero_id' => $genero_id,
                    'generoable_id' => $pelicula_id,
                    'generoable_type' => Pelicula::class,
                ]);
            }
        }

        // Asignar géneros a videojuegos
        foreach ($videojuegos as $videojuego_id) {
            $numGeneros = rand(1, 3); // Asigna entre 1 y 3 géneros
            $generosSeleccionados = $generos->random($numGeneros);

            foreach ($generosSeleccionados as $genero_id) {
                DB::table('generoables')->insert([
                    'genero_id' => $genero_id,
                    'generoable_id' => $videojuego_id,
                    'generoable_type' => Videojuego::class,
                ]);
            }
        }
    }
}
