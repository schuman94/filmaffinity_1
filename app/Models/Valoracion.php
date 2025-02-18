<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    /** @use HasFactory<\Database\Factories\ValoracionFactory> */
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = ['user_id', 'puntuacion', 'comentario', 'valorable_id', 'valorable_type'];

    public function valorable() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
