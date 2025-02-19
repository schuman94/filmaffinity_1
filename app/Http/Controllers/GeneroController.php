<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneroRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateGeneroRequest;
use App\Models\Genero;
use Illuminate\Validation\Rule;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('generos.index', [
            'generos' => Genero::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:generos,nombre',
        ]);

        $genero = Genero::create($validated);
        session()->flash('exito', 'Género creado correctamente.');
        return redirect()->route('generos.show', $genero);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genero $genero)
    {
        $videojuegos = $genero->videojuegos()->paginate(3);
        return view('generos.show', [
            'genero' => $genero,
            'videojuegos' => $videojuegos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genero $genero)
    {
        return view('generos.edit', [
            'genero' => $genero,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genero $genero)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                Rule::unique('generos')->ignore($genero),
            ],
        ]);

        $genero->fill($validated);
        $genero->save();
        session()->flash('exito', 'Genero modificado correctamente.');
        return redirect()->route('generos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero)
    {
        $genero->delete();
        return redirect()->route('generos.index');
    }
}
