<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    /** @use HasFactory<\Database\Factories\GeneroFactory> */
    use HasFactory;

    protected $fillable = ['nombre'];

    public function videojuegos(){
        return $this->morphedByMany(Videojuego::class, 'generoable');
    }

    public function peliculas(){
        return $this->morphedByMany(Pelicula::class, 'generoable');
    }

}
