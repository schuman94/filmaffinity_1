<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDesarrolladorRequest;
use App\Http\Requests\UpdateDesarrolladorRequest;
use Illuminate\Http\Request;
use App\Models\Desarrollador;

class DesarrolladorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('desarrolladores.index', [
            'desarrolladores' => Desarrollador::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desarrolladores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $desarrollador = Desarrollador::create($validated);
        session()->flash('exito', 'Desarrollador creado correctamente.');
        return redirect()->route('desarrolladores.show', $desarrollador);
    }

    /**
     * Display the specified resource.
     */
    public function show(Desarrollador $desarrollador)
    {
        return view('desarrolladores.show', [
            'desarrollador' => $desarrollador,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desarrollador $desarrollador)
    {
        return view('desarrolladores.edit',[
            'desarrollador' => $desarrollador,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desarrollador $desarrollador)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $desarrollador->fill($validated);
        $desarrollador->save();
        session()->flash('exito', 'Desarrollador modificado correctamente.');
        return redirect()->route('desarrolladores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desarrollador $desarrollador)
    {
        $desarrollador->delete();
        return redirect()->route('desarrolladores.index');
    }
}
