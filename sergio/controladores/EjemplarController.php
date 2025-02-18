<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EjemplarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ejemplares.index', [
            'ejemplares' => Ejemplar::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $libros = Libro::all();
        return view('ejemplares.create', [
            'libros' => $libros
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => [
                'required',
                'numeric',
                'digits_between:1,6',
                'unique:ejemplares,codigo', // Verifica que sea único en la tabla `ejemplares`
            ],
            'libro_id' => [
                'required',
                'integer',
                'exists:libros,id',
            ],
        ]);

        $ejemplar = Ejemplar::create($validated);
        session()->flash('exito', 'Ejemplar creado correctamente.');
        return redirect()->route('ejemplares.show', $ejemplar);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ejemplar $ejemplar)
    {
        return view('ejemplares.show', [
            'ejemplar' => $ejemplar,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ejemplar $ejemplar)
    {
        $libros = Libro::all();
        return view('ejemplares.edit', [
            'ejemplar' => $ejemplar,
            'libros' => $libros
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ejemplar $ejemplar)
    {
        $validated = $request->validate([
            'codigo' => [
                'required',
                'numeric',
                'digits_between:1,6',
                Rule::unique('ejemplares')->ignore($ejemplar), // Verifica que sea único en la tabla `ejemplares` ignorando su propio codigo
            ],
            'libro_id' => [
                'required',
                'integer',              // Verifica que sea un número entero
                'exists:libros,id',     // Verifica que el libro existe en la tabla `libros`
            ],
        ]);

        $ejemplar->fill($validated);
        $ejemplar->save();
        session()->flash('exito', 'Ejemplar modificado correctamente.');
        return redirect()->route('ejemplares.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ejemplar $ejemplar)
    {
        $ejemplar->delete();
        return redirect()->route('ejemplares.index');
    }
}
