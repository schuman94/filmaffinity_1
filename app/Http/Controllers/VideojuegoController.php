<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideojuegoRequest;
use App\Http\Requests\UpdateVideojuegoRequest;
use App\Models\Desarrollador;
use App\Models\Foro;
use App\Models\Genero;
use App\Models\User;
use App\Models\Videojuego;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Valoracion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

        // En la relacion polimorfica, el asociate lo debe iniciar quien debe almacenar la clave ajena
        $foro = new Foro();
        $foro->forable()->associate($videojuego);
        $foro->save();

        session()->flash('exito', 'Videojuego creado correctamente.');
        return redirect()->route('videojuegos.show', $videojuego);
    }

    /**
     * Display the specified resource.
     */
    public function show(Videojuego $videojuego)
    {
        $generos = Genero::whereNotIn('id', $videojuego->generos()->pluck('id'))->get();

        return view('videojuegos.show', [
            'videojuego' => $videojuego,
            'generos' => $generos,
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
        if (! Gate::allows('anyadir-genero')) {
            abort(403);
        }

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
        // Usando politicas
        Gate::authorize('valorar', $videojuego);

        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:0|max:10',
            'comentario' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['valorable_id'] = $videojuego->id;
        $validated['valorable_type'] = Videojuego::class;

        $valoracion = Valoracion::create($validated);
        session()->flash('exito', 'Valoración creada correctamente.');
        return redirect()->route('valoraciones.show', $valoracion);
    }


    public function eliminados()
    {
        $videojuegos = Videojuego::onlyTrashed()->paginate(10);

        return view('videojuegos.eliminados', [
            'videojuegos' => $videojuegos,
        ]);
    }

    // Aquí en vez del parámetros Videojuego $videojuego, debemos indicar $id.
    // Laravel no inyecta objetos eliminados, tan solo obtenemos un integer.
    public function restaurar($id)
    {
        // Por lo tanto, hay que obtener el videojuego a partir de su id
        $videojuego = Videojuego::onlyTrashed()->find($id);

        if (!$videojuego) {
            return redirect()->route('videojuegos.eliminados')->with('error', 'Videojuego no encontrada.');
        }

        $videojuego->restore();

        session()->flash('exito', 'Videojuego restaurado.');
        return redirect()->route('videojuegos.show', $videojuego);
    }

    public function ranking(Request $request)
    {
        // Obtener todos los géneros para la vista
        $generos = Genero::all();

        // Iniciar la consulta base
        $query = Videojuego::query();


        // Filtrar por fecha de lanzamiento
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Si ambas fechas están presentes, filtrar entre ellas
            $query->whereBetween('fecha_lanzamiento', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            // Si solo hay fecha de inicio, filtrar desde esa fecha en adelante
            $query->where('fecha_lanzamiento', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            // Si solo hay fecha de fin, filtrar hasta esa fecha
            $query->where('fecha_lanzamiento', '<=', $request->fecha_fin);
        }

        // Filtrar por género
        if ($request->filled('genero_id')) {
            $query->whereHas('generos', function ($q) use ($request) {
                $q->where('generos.id', $request->genero_id);
            });
        }

        // Filtrar por desarrollador
        if ($request->filled('desarrollador')) {
            $query->whereHas('desarrollador', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->desarrollador . '%');
            });
        }

        // Obtener todas ls videojuegos con las valoraciones
        $videojuegos = $query->with('valoraciones')->get();

        // Filtrar en PHP por puntuación mínima
        if ($request->filled('puntuacion_minima')) {
            $videojuegos = $videojuegos->filter(function ($videojuego) use ($request) {
                return $videojuego->valoraciones->pluck('puntuacion')->avg() >= $request->puntuacion_minima;
            });
        }

        // Ordenar por puntuación promedio en PHP
        $videojuegos = $videojuegos->sortByDesc(function ($videojuego) {
            return $videojuego->valoraciones->pluck('puntuacion')->avg() ?? 0;
        });

        return view('videojuegos.ranking', [
            'videojuegos' => $videojuegos,
            'generos' => $generos,
        ]);
    }
}
