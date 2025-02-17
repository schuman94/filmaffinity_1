<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videojuego extends Model
{
    /** @use HasFactory<\Database\Factories\VideojuegoFactory> */
    use HasFactory;

    public function desarrollador(){
        return $this->belongsTo(Desarrollador::class);
    }

    public function generos(){
        return $this->morphToMany(Genero::class, 'generoable');
    }

    public function valoraciones() {
        return $this->morphMany(Valoracion::class, 'valorable');
    }
}
