<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreValoracionRequest;
use App\Http\Requests\UpdateValoracionRequest;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreValoracionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Valoracion $valoracion)
    {
        return view('valoraciones.show', [
            'valoracion' => $valoracion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valoracion $valoracion)
    {
        return view('valoraciones.edit',[
            'valoracion' => $valoracion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Valoracion $valoracion)
    {
        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:0|max:10',
            'comentario' => 'required|string',
        ]);

        $valoracion->fill($validated);
        $valoracion->save();
        session()->flash('exito', 'Valoracion modificada correctamente.');
        return redirect()->route('valoraciones.show', $valoracion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valoracion $valoracion)
    {
        //
    }

}
