<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desarrollador extends Model
{
    /** @use HasFactory<\Database\Factories\DesarrolladorFactory> */
    use HasFactory;

    protected $table = 'desarrolladores';

    protected $fillable = ['nombre'];

    public function videojuegos() {
        return $this->hasMany(Videojuego::class);
    }

}
