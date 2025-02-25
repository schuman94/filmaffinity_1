<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Foro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Verificar si existe al menos un comentario
        $hayComentarios = Comentario::exists();

        if ($hayComentarios) {
            $comentable = fake()->boolean() ? Comentario::inRandomOrder()->first() : Foro::inRandomOrder()->first();
        } else {
            $comentable = Foro::inRandomOrder()->first();
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'contenido' => fake()->sentence(20),
            'comentable_id' => $comentable->id,
            'comentable_type' => get_class($comentable),
        ];
    }
}
