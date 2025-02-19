<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideojuegoRequest;
use App\Http\Requests\UpdateVideojuegoRequest;
use App\Models\Desarrollador;
use App\Models\Genero;
use App\Models\Videojuego;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Valoracion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VideojuegoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('videojuegos.index', [
            'videojuegos' => Videojuego::paginate(20),
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
        $generos = Genero::whereNotIn('id', $videojuego->generos()->pluck('id'))->get();

        $valoracionExiste = Valoracion::where('user_id', Auth::id())
        ->where('valorable_id', $videojuego->id)
        ->where('valorable_type', Videojuego::class)
        ->exists();

        return view('videojuegos.show', [
            'videojuego' => $videojuego,
            'generos' => $generos,
            'valoracionExiste' => $valoracionExiste,
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
            'genero_id' => [
            'required',
            'integer',
            'exists:generos,id',
            Rule::unique('generoables')
                ->where('generoable_type', Videojuego::class)
                ->where('generoable_id', $videojuego->id),
            ],
        ]);

        $videojuego->generos()->attach($validated['genero_id']);

        return redirect()->route('videojuegos.show', $videojuego);
    }

    public function valorar(Request $request, Videojuego $videojuego)
    {
        // Se comprueba si ya existe una valoración del usuario para la videojuego
        $valoracionExiste = Valoracion::where('user_id', Auth::id())
        ->where('valorable_id', $videojuego->id)
        ->where('valorable_type', Videojuego::class)
        ->exists();

        if ($valoracionExiste) {
            session()->flash('error', 'Ya has valorado este videojuego.');
            return redirect()->back();
        }

        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:0|max:10',
            'comentario' => 'required|string',
        ]);

        // Si no existe, crea la valoración
        $validated['user_id'] = Auth::id();
        $validated['valorable_id'] = $videojuego->id;
        $validated['valorable_type'] = Videojuego::class;

        $valoracion = Valoracion::create($validated);
        session()->flash('exito', 'Valoración creada correctamente.');
        return redirect()->route('valoraciones.show', $valoracion);
    }
}
