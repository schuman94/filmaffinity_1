<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    /** @use HasFactory<\Database\Factories\GeneroFactory> */
    use HasFactory;

    public function videojuegos(){
        return $this->morphedByMany(Videojuego::class, 'taggable');
    }

    public function peliculas(){
        return $this->morphedByMany(Pelicula::class, 'taggable');
    }
}
