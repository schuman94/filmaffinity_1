<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeliculaRequest;
use App\Http\Requests\UpdatePeliculaRequest;
use App\Models\Genero;
use App\Models\Pelicula;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeliculaValoradaMd;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::paginate(20),
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

        $generos = Genero::whereNotIn('id', $pelicula->generos()->pluck('id'))->get();

        return view('peliculas.show', [
            'pelicula' => $pelicula,
            'generos' => $generos,
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
        if (! Gate::allows('anyadir-genero')) {
            abort(403);
        }

        $validated = $request->validate([
            'genero_id' => [
            'required',
            'integer',
            'exists:generos,id',
            Rule::unique('generoables')
                ->where('generoable_type', Pelicula::class)
                ->where('generoable_id', $pelicula->id),
            ],
        ]);

        $pelicula->generos()->attach($validated['genero_id']);

        return redirect()->route('peliculas.show', $pelicula);
    }

    public function valorar(Request $request, Pelicula $pelicula)
    {

        if (Gate::allows('pelicula-valorada', $pelicula)) {
            abort(403);
            //session()->flash('error', 'Ya has valorado esta película.');
            //return redirect()->back();
        }

        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:0|max:10',
            'comentario' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['valorable_id'] = $pelicula->id;
        $validated['valorable_type'] = Pelicula::class;

        $valoracion = Valoracion::create($validated);

        Mail::to(Auth::user()->email)->send(new PeliculaValoradaMd($valoracion, $pelicula));

        session()->flash('exito', 'Valoración creada correctamente.');
        return redirect()->route('valoraciones.show', $valoracion);
    }

    public function eliminadas()
    {
        $peliculas = Pelicula::onlyTrashed()->paginate(10);

        return view('peliculas.eliminadas', [
            'peliculas' => $peliculas,
        ]);
    }

    // Aquí en vez del parámetros Pelicula $pelicula, debemos indicar $id.
    // Laravel no inyecta objetos eliminados, tan solo obtenemos un integer.
    public function restaurar($id)
    {
        // Por lo tanto, hay que obtener la pelicula a partir de su id
        $pelicula = Pelicula::onlyTrashed()->find($id);

        if (!$pelicula) {
            return redirect()->route('peliculas.eliminadas')->with('error', 'Película no encontrada.');
        }

        $pelicula->restore();

        session()->flash('exito', 'Pelicula restaurada.');
        return redirect()->route('peliculas.show', $pelicula);
    }

    public function ranking(Request $request)
    {
        // Obtener todos los géneros para la vista
        $generos = Genero::all();

        // Iniciar la consulta base
        $query = Pelicula::query();

        // Filtrar por fecha de estreno
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Si ambas fechas están presentes, filtrar entre ellas
            $query->whereBetween('fecha_estreno', [$request->fecha_inicio, $request->fecha_fin]);
        } elseif ($request->filled('fecha_inicio')) {
            // Si solo hay fecha de inicio, filtrar desde esa fecha en adelante
            $query->where('fecha_estreno', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            // Si solo hay fecha de fin, filtrar hasta esa fecha
            $query->where('fecha_estreno', '<=', $request->fecha_fin);
        }

        // Filtrar por género
        if ($request->filled('genero_id')) {
            $query->whereHas('generos', function ($q) use ($request) {
                $q->where('generos.id', $request->genero_id);
            });
        }

        // Filtrar por director
        if ($request->filled('director')) {
            $query->where('director', 'like', '%' . $request->director . '%');
        }

        // Obtener todas las películas con las valoraciones
        $peliculas = $query->with('valoraciones')->get();

        // Filtrar en PHP por puntuación mínima
        if ($request->filled('puntuacion_minima')) {
            $peliculas = $peliculas->filter(function ($pelicula) use ($request) {
                return $pelicula->valoraciones->pluck('puntuacion')->avg() >= $request->puntuacion_minima;
            });
        }

        // Ordenar por puntuación promedio en PHP
        $peliculas = $peliculas->sortByDesc(function ($pelicula) {
            return $pelicula->valoraciones->pluck('puntuacion')->avg() ?? 0;
        });

        return view('peliculas.ranking', [
            'peliculas' => $peliculas,
            'generos' => $generos,
        ]);
    }
}
