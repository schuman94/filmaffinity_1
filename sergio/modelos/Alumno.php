<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Alumno extends Model
{
    protected $fillable = ['nombre'];

    public function notas() {
        return $this->hasMany(Nota::class);
    }

    // No la estoy usando (me devuelve todos los criterios que esten asociados con un alumno a traves de la tabla notas)
    public function criterios() {
        return $this->hasManyThrough(
            Ce::class,       // Modelo final (tabla ccee)
            Nota::class,     // Modelo intermedio (tabla notas)
            'alumno_id',     // Foreign key en la tabla intermedia (notas) que apunta a la inicial (alumnos)
            'id',            // Primary key en la tabla final (ccee)
            'id',            // Primary key en la tabla inicial (alumnos)
            'ccee_id'        // Foreign key en la tabla intermedia (notas) que apunta a la tabla final (ccee)
        );
    }

    public function nota_final()
    {
        return $this->notas()
            ->select(DB::raw('MAX(nota) as nota_maxima'), 'ccee_id')
            ->groupBy('ccee_id')
            ->get()
            ->avg('nota_maxima');
    }
}
