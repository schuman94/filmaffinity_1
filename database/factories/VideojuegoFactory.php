<?php

namespace Database\Factories;

use App\Models\Desarrollador;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Videojuego>
 */
class VideojuegoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->unique()->sentence(3),
            'desarrollador_id' => Desarrollador::all()->shuffle()->first()->id,
            'fecha_lanzamiento' => Carbon::instance(fake()->dateTimeBetween('-100 years', 'now')),
        ];
    }
}
