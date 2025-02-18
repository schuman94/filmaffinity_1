<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideojuegoRequest;
use App\Http\Requests\UpdateVideojuegoRequest;
use App\Models\Desarrollador;
use App\Models\Genero;
use Illuminate\Http\Request;
use App\Models\Videojuego;
use Carbon\Carbon;

class VideojuegoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('videojuegos.index', [
            'videojuegos' => Videojuego::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desarrolladores = Desarrollador::all();
        return view('videojuegos.create', [
            'desarrolladores' => $desarrolladores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'desarrollador_id' => 'required|integer|exists:desarrolladores,id',
            'fecha_lanzamiento' => 'required|date_format:d-m-Y',
        ]);

        $validated['fecha_lanzamiento'] = Carbon::createFromFormat('d-m-Y', $validated['fecha_lanzamiento'], "Europe/Madrid")->utc();

        $videojuego = Videojuego::create($validated);
        session()->flash('exito', 'Videojuego creado correctamente.');
        return redirect()->route('videojuegos.show', $videojuego);
    }

    /**
     * Display the specified resource.
     */
    public function show(Videojuego $videojuego)
    {
        $generos = Genero::all();
        return view('videojuegos.show', [
            'videojuego' => $videojuego,
            'generos' => $generos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videojuego $videojuego)
    {
        $desarrolladores = Desarrollador::all();
        return view('videojuegos.edit',[
            'videojuego' => $videojuego,
            'desarrolladores' => $desarrolladores,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videojuego $videojuego)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'desarrollador_id' => 'required|integer|exists:desarrolladores,id',
            'fecha_lanzamiento' => 'required|date|date_format:d-m-Y',
        ]);

        $validated['fecha_lanzamiento'] = Carbon::createFromFormat('d-m-Y', $validated['fecha_lanzamiento'], "Europe/Madrid")->utc();
        $videojuego->fill($validated);
        $videojuego->save();
        session()->flash('exito', 'Videojuego modificado correctamente.');
        return redirect()->route('videojuegos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videojuego $videojuego)
    {
        $videojuego->delete();
        return redirect()->route('videojuegos.index');
    }

    public function anyadir_genero(Request $request, Videojuego $videojuego)
    {
        $validated = $request->validate([
            'genero_id' => 'required|integer|exists:generos,id',
        ]);

        $videojuego->generos()->attach($validated['genero_id']);

        return redirect()->route('videojuegos.show', $videojuego);
    }
}
