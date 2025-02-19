<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Pelicula;
use App\Models\Valoracion;
use App\Models\Videojuego;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoracion>
 */
class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // NO SE ESTÁ USANDO
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $valorable = fake()->boolean() ? Pelicula::inRandomOrder()->first() : Videojuego::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'puntuacion' => rand(0, 10),
            'comentario' => fake()->sentence(20),
            'valorable_id' => $valorable->id,
            'valorable_type' => get_class($valorable),
        ];
    }
}
