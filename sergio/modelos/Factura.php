<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /** @use HasFactory<\Database\Factories\FacturaFactory> */
    use HasFactory;

    protected $fillable = ['codigo', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function articulos() {
        return $this->belongsToMany(Articulo::class)
            ->withPivot('cantidad');
    }

    public function calcular_precio() {
        return $this->articulos->sum(function ($articulo) {
            return $articulo->pivot->cantidad * $articulo->precio;
        });
    }

}
