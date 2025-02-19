<?php

use Illuminate\Support\Facades\DB;
use App\Models\Alumno;
use App\Models\Nota;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Entrada;
use App\Models\Libro;
use App\Models\Proyeccion;
use App\Models\Pelicula;

// Obtener todos los registros
$alumnos = Alumno::all();
$libros = Libro::all(); // Devuelve todos los libros

// Filtrar registros con condiciones
$alumnosJuan = Alumno::where('nombre', 'LIKE', '%Juan%')->get();
$notasAltas = Nota::where('nota', '>', 7)->where('alumno_id', 1)->get();

// Agregar una condición OR
$alumnosJuanPedro = Alumno::where('nombre', 'LIKE', '%Juan%')
    ->orWhere('nombre', 'LIKE', '%Pedro%')
    ->get();

// Filtrar por un conjunto de valores
$clientesSeleccionados = Cliente::whereIn('id', [1, 3, 5])->get();
$proyeccionesEspecificas = Proyeccion::whereIn('sala_id', [2, 4])->get();

// Filtrar donde los valores **no** están en un conjunto
$librosExcluidos = Libro::whereNotIn('id', [1, 2, 3])->get();

// Filtrar registros donde una columna es NULL o NOT NULL
$prestamosPendientes = Prestamo::whereNull('fecha_dev')->get();
$facturasPagadas = Factura::whereNotNull('fecha_pago')->get();

// Ordenar registros por columna
$alumnosOrdenados = Alumno::orderBy('nombre', 'asc')->get();
$entradasOrdenadas = Entrada::orderBy('precio', 'desc')->get();

// Limitar el número de registros
$primerosAlumnos = Alumno::orderBy('id')->take(10)->get();
$primerosPrestamos = Prestamo::limit(5)->get();

// Cargar relaciones definidas en el modelo (eager loading)
$facturasConArticulos = Factura::with('articulos')->get();
$alumnosConNotas = Alumno::with('notas')->get();

// Filtrar registros con relaciones asociadas
$facturasConArticulos = Factura::has('articulos')->get();
$alumnosConNotasAltas = Alumno::whereHas('notas', function ($query) {
    $query->where('nota', '>', 8);
})->get();

// Filtrar registros sin relaciones asociadas
$alumnosSinNotas = Alumno::doesntHave('notas')->get();
$facturasSinArticulos = Factura::whereDoesntHave('articulos')->get();

// Obtener el primer registro que coincida o lanzar una excepción si no encuentra
$alumno = Alumno::where('nombre', 'Juan')->first();
$prestamo = Prestamo::where('id', 1)->firstOrFail();

// Buscar un registro por su ID
$alumno = Alumno::find(1);
$factura = Factura::findOrFail(10);

// Operaciones de agregación
$totalAlumnos = Alumno::count();
$notaMedia = Nota::where('alumno_id', 1)->avg('nota');
$totalPrecioFacturas = Factura::sum('total');
$notaMasAlta = Nota::max('nota');

// Agrupar registros y aplicar filtros a los grupos
$notasPorCriterio = Nota::select('ccee_id', DB::raw('MAX(nota) as max_nota'))
    ->groupBy('ccee_id')
    ->having('max_nota', '>', 7)
    ->get();

// Consultas paginadas
$alumnosPaginados = Alumno::paginate(10);

// Relación hasManyThrough: Obtener criterios a través de las notas
$criteriosAlumno = Alumno::find(1)->criterios; // Relación definida en el modelo

// Usar join para combinar datos de varias tablas
$criteriosNotasAltas = Nota::join('ccee', 'notas.ccee_id', '=', 'ccee.id')
    ->select('ccee.ce', DB::raw('MAX(notas.nota) as max_nota'))
    ->groupBy('ccee.ce')
    ->get();

// Filtrar registros con múltiples condiciones
$entradasSeleccionadas = Entrada::where('precio', '>', 10)
    ->whereIn('proyeccion_id', [1, 2])
    ->get();


// PRACTICADOS

// Consulta 1: Todas las peliculas que tienen al menos una proyección en una sala especifica.

$consulta1 = Pelicula::whereHas('proyecciones', function ($query) use ($sala){
    $query->where('sala_id', $sala->id);
})->get();


// Consulta 2: Todos los clientes que han realizado al menos un préstamo,
// incluyendo el numero total de prestamos realizado por cada cliente y la fecha del prestamo más reciente de cada cliente.
// Ordena el resultado por el número total de préstamos en orden descendente.

$consulta2 = Cliente::has('prestamos') // Clientes que tienen al menos un préstamo
    ->withCount('prestamos') // Contar el total de préstamos por cliente
    ->with(['prestamos' => function ($query) {
        $query->orderBy('fecha_hora', 'desc'); // Ordenar los préstamos por fecha
    }])
    ->orderBy('prestamos_count', 'desc') // Ordenar clientes por cantidad de préstamos
    ->get();
