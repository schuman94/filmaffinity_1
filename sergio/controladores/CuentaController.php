<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cuentas.index', [
            'cuentas' => Cuenta::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Cuenta $cuenta)
    {
        $fecha = $request->query('fecha');
        if (isset($fecha)) {
            $request->validate([
                'fecha' => 'date_format:Y-m-d',
            ]);
        }

        $movimientos = $cuenta->movimientos();

        if (isset($fecha)) {
            $movimientos->whereRaw("to_char(created_at, 'YYYY-MM-DD') = ?", [$fecha]);
        }

        return view('cuentas.show', [
            'cuenta' => $cuenta,
            'movimientos' => $movimientos->orderBy('created_at')->get(),
            'fecha' => $fecha,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuenta $cuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuenta $cuenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuenta $cuenta)
    {
        //
    }
}
