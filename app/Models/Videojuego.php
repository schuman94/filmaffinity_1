<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videojuego extends Model
{
    /** @use HasFactory<\Database\Factories\VideojuegoFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['titulo', 'desarrollador_id', 'fecha_lanzamiento'];

    //protected $casts = [
    //    'fecha_lanzamiento' => 'datetime',
    //];

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
