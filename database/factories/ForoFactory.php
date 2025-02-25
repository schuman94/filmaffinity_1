<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pelicula;
use App\Models\Videojuego;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Foro>
 */
class ForoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $forable = fake()->boolean() ? Pelicula::inRandomOrder()->first() : Videojuego::inRandomOrder()->first();
        return [
            'forable_id' => $forable->id,
            'forable_type' => get_class($forable),
        ];
    }
}
