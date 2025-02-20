<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelicula extends Model
{
    /** @use HasFactory<\Database\Factories\PeliculaFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['titulo', 'director', 'fecha_estreno'];

    public function generos(){
        return $this->morphToMany(Genero::class, 'generoable');
    }

    public function valoraciones() {
        return $this->morphMany(Valoracion::class, 'valorable');
    }
}
