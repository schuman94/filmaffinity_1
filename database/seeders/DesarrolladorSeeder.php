<?php

namespace Database\Seeders;

use App\Models\Desarrollador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesarrolladorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Desarrollador::factory()->count(20)->create();
    }
}
