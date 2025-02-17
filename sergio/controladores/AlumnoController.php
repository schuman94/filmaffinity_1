<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Ce;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('alumnos.index', [
            'alumnos' => Alumno::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alumnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
        ]);

        $alumno = Alumno::create($validated);
        session()->flash('exito', 'Alumno creado correctamente.');
        return redirect()->route('alumnos.show', $alumno);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        return view('alumnos.show', [
            'alumno' => $alumno,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', [
            'alumno' => $alumno,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
        ]);

        $alumno->fill($validated);
        $alumno->save();
        session()->flash('exito', 'Alumno modificado correctamente.');
        return redirect()->route('alumnos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index');
    }

    public function criterios(Alumno $alumno)
    {
        // Obtengo todos los criterios (distinct) que:
            // esten en la tabla notas y cuyo alumno_id sea el indicado
            // hacemos combinacion con la tabla notas
            // cada criterio contiene tantas filas de notas como veces aparezca el criterio en la tabla notas (de ese alumno)
            // ordenamos las notas DESC
            // obtenemos una coleccion de criterios para recorrer con un foreach $criterios as $criterio
            // A un $criterio se le puede obtener la nota más alta con $criterio->notas->first()->nota
        $criterios = Ce::whereHas('notas', function ($query) use ($alumno) {
            $query->where('alumno_id', $alumno->id);
        })->with(['notas' => function ($query) use ($alumno) {
            $query->where('alumno_id', $alumno->id)->orderByDesc('nota');
        }])->get();

        return view('alumnos.criterios', [
            'alumno' => $alumno,
            'criterios' => $criterios
        ]);
    }
}
