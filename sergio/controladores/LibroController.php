<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('libros.index', [
            'libros' => Libro::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('libros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255'
        ]);

        $libro = Libro::create($validated);
        session()->flash('exito', 'Libro creado correctamente.');
        return redirect()->route('libros.show', $libro);
    }

    /**
     * Display the specified resource.
     */
    public function show(Libro $libro)
    {
        return view('libros.show', [
            'libro' => $libro,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Libro $libro)
    {
        return view('libros.edit',[
            'libro' => $libro,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255'
        ]);

        $libro->fill($validated);
        $libro->save();
        session()->flash('exito', 'Libro modificado correctamente.');
        return redirect()->route('libros.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index');
    }
}
