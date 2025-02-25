<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComentarioRequest;
use App\Http\Requests\UpdateComentarioRequest;
use App\Models\Comentario;
use App\Models\Foro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    public function redactar_respuesta(Request $request, Comentario $comentario)
    {
        return view('comentarios.create',[
            'comentario' => $comentario
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Foro $foro)
    {
        //
    }

    public function comentar(Request $request, Foro $foro)
    {
        $validated = $request->validate([
            'contenido' => 'required|string',
        ]);



        $validated['user_id'] = Auth::id();

        $comentario = new Comentario($validated);
        $comentario->comentable()->associate($foro);

        $comentario->save();

        session()->flash('exito', 'Comentario creado correctamente.');
        return redirect()->route('foros.show', $foro);

    }

    public function responder(Request $request, Comentario $comentario)
    {
        $validated = $request->validate([
            'contenido' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        //Renombramos la variable, ya que se va a crear otro comentario
        $padre = $comentario;

        $comentario = new Comentario($validated);
        $comentario->comentable()->associate($padre);
        $comentario->save();

        // Buscar el foro en la cadena de respuestas
        $comentable = $comentario->comentable;
        while ($comentable instanceof Comentario) {
            $comentable = $comentable->comentable;
        }

        // Ahora $comentable es un Foro
        if ($comentable instanceof Foro) {
            session()->flash('exito', 'Comentario creado correctamente.');
            return redirect()->route('foros.show', $comentable);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        //
    }
}
