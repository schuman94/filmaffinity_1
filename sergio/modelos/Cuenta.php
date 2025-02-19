<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Pest\Laravel\get;

class Cuenta extends Model
{
    /** @use HasFactory<\Database\Factories\CuentaFactory> */
    use HasFactory;

    public function movimientos() {
        return $this->hasMany(Movimiento::class);
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function saldo() {
        return $this->movimientos()->sum('importe');
    }

    public function saldo_parcial($movimiento) {
        return $this->movimientos()->where('created_at', '<=', $movimiento->created_at)->sum('importe');
    }
}
