<?php

namespace Database\Seeders;

use App\Models\Valoracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelicula;
use App\Models\Videojuego;
use App\Models\User;

class ValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::pluck('id');
        $peliculas = Pelicula::pluck('id');
        $videojuegos = Videojuego::pluck('id');

        $valoracionesGeneradas = [];

        while (count($valoracionesGeneradas) < 100) {
            $user_id = $usuarios->random();
            $esPelicula = fake()->boolean();
            $valorable_id = $esPelicula ? $peliculas->random() : $videojuegos->random();
            $valorable_type = $esPelicula ? Pelicula::class : Videojuego::class;

            $key = "{$user_id}-{$valorable_id}-{$valorable_type}";

            // Verificar que no se haya generado antes
            if (!isset($valoracionesGeneradas[$key])) {
                Valoracion::create([
                    'user_id' => $user_id,
                    'puntuacion' => rand(0, 10),
                    'comentario' => fake()->sentence(20),
                    'valorable_id' => $valorable_id,
                    'valorable_type' => $valorable_type,
                ]);

                $valoracionesGeneradas[$key] = true;
            }
        }
    }
}
