<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeliculaRequest;
use App\Http\Requests\UpdatePeliculaRequest;
use App\Models\Genero;
use App\Models\Pelicula;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peliculas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'fecha_estreno' => 'required|date_format:d-m-Y',
        ]);

        $validated['fecha_estreno'] = Carbon::createFromFormat('d-m-Y', $validated['fecha_estreno'], "Europe/Madrid")->utc();

        $pelicula = Pelicula::create($validated);
        session()->flash('exito', 'Pelicula creada correctamente.');
        return redirect()->route('peliculas.show', $pelicula);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelicula $pelicula)
    {
        $generos = Genero::all();
        return view('peliculas.show', [
            'pelicula' => $pelicula,
            'generos' => $generos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelicula $pelicula)
    {
        return view('peliculas.edit',[
            'pelicula' => $pelicula,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelicula $pelicula)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'fecha_estreno' => 'required|date|date_format:d-m-Y',
        ]);

        $validated['fecha_estreno'] = Carbon::createFromFormat('d-m-Y', $validated['fecha_estreno'], "Europe/Madrid")->utc();
        $pelicula->fill($validated);
        $pelicula->save();
        session()->flash('exito', 'Pelicula modificada correctamente.');
        return redirect()->route('peliculas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelicula $pelicula)
    {
        $pelicula->delete();
        return redirect()->route('peliculas.index');
    }

    public function anyadir_genero(Request $request, Pelicula $pelicula)
    {
        $validated = $request->validate([
            'genero_id' => 'required|integer|exists:generos,id',
        ]);

        $pelicula->generos()->attach($validated['genero_id']);

        return redirect()->route('peliculas.show', $pelicula);
    }


}
