<?php

namespace App\Http\Controllers;

use App\Models\Videojuego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class VideojuegoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('videojuegos.index', [
            //'videojuegos' => Auth::user()->videojuegos, // Esto es para que solo aparezcan los del user logeado
            'videojuegos' => Videojuego::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videojuegos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string',
            'desarrollador' => 'required|string'
        ]);

        $videojuego = Videojuego::create($validated);
        session()->flash('exito', 'Videojuego creado correctamente.');
        return redirect()->route('videojuegos.show', $videojuego);
    }

    /**
     * Display the specified resource.
     */
    public function show(Videojuego $videojuego)
    {
        return view('videojuegos.show', [
            'videojuego' => $videojuego,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videojuego $videojuego)
    {
        return view('videojuegos.edit',[
            'videojuego' => $videojuego,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videojuego $videojuego)
    {
        $validated = $request->validate([
            'titulo' => 'required|string',
            'desarrollador' => 'required'
        ]);

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

    public function adquirir(Videojuego $videojuego)
    {

        //Esto lo ignoramos porque ya hemos metido el middleware('auth') en el web.php
        /*  if (!Auth::user()) {
                abort(403, 'Usuario no autenticado.');
            }
        */

        // Verificar si el videojuego ya está asociado
        if (Auth::user()->videojuegos()->where('videojuego_id', $videojuego->id)->exists()) {
            // Incrementar la cantidad en la tabla pivot
            Auth::user()->videojuegos()->updateExistingPivot($videojuego->id, [
                'cantidad' => DB::raw('cantidad + 1')
            ]);
            session()->flash('exito', 'Videojuego adquirido otra vez.');
        } else {
            // Crear una nueva relación con cantidad inicial de 1
            Auth::user()->videojuegos()->attach($videojuego->id);
            session()->flash('exito', 'Videojuego adquirido.');
        }

        return redirect()->route('videojuegos.index');
    }


}
//$videojuego->users()->attach(Auth::user());
