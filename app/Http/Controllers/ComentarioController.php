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
        $comentable_type = $request->query('comentable_type');
        $comentable_id = $request->query('comentable_id');

        return view('comentarios.create',[
            'comentable_type' => $comentable_type,
            'comentable_id' => $comentable_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Esta validacion no comprueba si existe el comentable
        $validated = $request->validate([
            'contenido' => 'required|string',
            'comentable_type' => 'required|string',
            'comentable_id' => 'required|integer',
        ]);

        $validated['user_id'] = Auth::id();

        $comentario = Comentario::create($validated);


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
