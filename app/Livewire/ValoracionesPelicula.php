<?php

namespace App\Livewire;

use App\Models\Pelicula;
use Livewire\Component;

class ValoracionesPelicula extends Component
{
    public $pelicula;

    public function mount(Pelicula $pelicula)
    {
        $this->pelicula = $pelicula;
    }

    public function eliminar()
    {
        $this->pelicula->valoraciones()->delete();
    }

    public function render()
    {
        return view('livewire.valoraciones-pelicula', [
            'pelicula' => $this->pelicula->fresh()
        ]);
    }
}
