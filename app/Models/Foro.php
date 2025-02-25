<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    /** @use HasFactory<\Database\Factories\ForoFactory> */
    use HasFactory;

    public function forable() {
        return $this->morphTo();
    }

    public function comentarios() {
        return $this->morphMany(Comentario::class, 'comentable');
    }
}
