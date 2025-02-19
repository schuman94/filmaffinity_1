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

        $valoracionExiste = Valoracion::where('user_id', Auth::id())
        ->where('valorable_id', $pelicula->id)
        ->where('valorable_type', Pelicula::class)
        ->exists();

        return view('peliculas.show', [
            'pelicula' => $pelicula,
            'generos' => $generos,
            'valoracionExiste' => $valoracionExiste,
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
        // Se comprueba si ya existe una valoración del usuario para la película
        $valoracionExiste = Valoracion::where('user_id', Auth::id())
        ->where('valorable_id', $pelicula->id)
        ->where('valorable_type', Pelicula::class)
        ->exists();

        if ($valoracionExiste) {
            session()->flash('error', 'Ya has valorado esta película.');
            return redirect()->back();
        }

        $validated = $request->validate([
            'puntuacion' => 'required|integer|min:0|max:10',
            'comentario' => 'required|string',
        ]);

        // Si no existe, crea la valoración
        $validated['user_id'] = Auth::id();
        $validated['valorable_id'] = $pelicula->id;
        $validated['valorable_type'] = Pelicula::class;

        $valoracion = Valoracion::create($validated);
        session()->flash('exito', 'Valoración creada correctamente.');
        return redirect()->route('valoraciones.show', $valoracion);
    }


}
