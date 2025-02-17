<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    /** @use HasFactory<\Database\Factories\LibroFactory> */
    use HasFactory;

    protected $fillable = ['titulo', 'autor'];

    public function ejemplares() {
        return $this->hasMany(Ejemplar::class);
    }

    public function ejemplares_disponibles() {
        $disponibles = $this->ejemplares()->whereNotIn('id', function(Builder $query) {
            $query->select('ejemplar_id')
            ->from('prestamos')
            ->whereNull('fecha_dev');
        })->get();

        return $disponibles;
    }
}
