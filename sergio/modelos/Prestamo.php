<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    /** @use HasFactory<\Database\Factories\PrestamoFactory> */
    use HasFactory;

    protected $fillable = ['ejemplar_id', 'cliente_id', 'fecha_hora'];
    protected $casts = [
        'fecha_hora' => 'datetime',
        'fecha_dev' =>'datetime',
    ];

    public function ejemplar() {
        return $this->belongsTo(Ejemplar::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function esta_vencido(): bool {
        $fechaVencimiento = $this->fecha_hora->addMonth();
        return $fechaVencimiento->isPast();
    }
}
