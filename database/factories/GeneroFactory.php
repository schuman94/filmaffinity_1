<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genero>
 */
class GeneroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement([
                'Carreras', 'Survival Horror', 'Plataformas', 'Shooters', 'Battle Royale', 'Metroidvania',
                'Lucha', 'Puzzle', 'Arcade', 'MMORPG', 'MOBA', 'Hack and Slash', 'Roguelike', 'Roguelite',
                'Stealth', 'Sandbox', 'Mundo Abierto', 'Ciencia Ficción', 'Fantasía', 'Cyberpunk',
                'Gore', 'Postapocalíptico', 'Zombis', 'Exploración', 'Survival', 'Construcción',
                'Aventura Gráfica', 'Visual Novel', 'Táctico', 'Cartas y Tablero', 'Musical',
                'Party Game', 'Shoot ‘em Up', 'Tower Defense', 'Realidad Virtual', 'Realidad Aumentada',
                'Horror Psicológico', 'Crimen y Misterio', 'Cómic y Superhéroes', 'Histórico', 'Western',
                'Anime', 'Magia', 'Vampiros', 'Piratas', 'Mitología', 'Guerra', 'Industrial',
                'Medieval', 'Espacial', 'Noir', 'SteamPunk', 'Biopunk', 'Dark Fantasy',
                'Acción', 'Aventura', 'Terror', 'Drama', 'Estrategia', 'RPG', 'Simulación', 'Deportes',
            ]),
        ];
    }
}
