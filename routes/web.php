<?php

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;

use App\Http\Controllers\DesarrolladorController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideojuegoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('desarrolladores', DesarrolladorController::class)->parameters([
    'desarrolladores' => 'desarrollador',
]);

Route::resource('videojuegos', VideojuegoController::class);
Route::resource('peliculas', PeliculaController::class);
Route::resource('generos', GeneroController::class);


Route::put('peliculas/{pelicula}/anyadir_genero', [PeliculaController::class, 'anyadir_genero'])->name('peliculas.anyadir_genero');
Route::put('videojuegos/{videojuego}/anyadir_genero', [VideojuegoController::class, 'anyadir_genero'])->name('videojuegos.anyadir_genero');







//  Route::get('alumnos/criterios/{alumno}', [AlumnoController::class, 'criterios'])->name('alumnos.criterios');

//  Route::put('prestamos/devolver/{prestamo}', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');

//  Route::post('videojuegos/adquirir/{videojuego}', [VideojuegoController::class, 'adquirir'])->name('videojuegos.adquirir')->middleware('auth');



//  Route::resource('ejemplares', EjemplarController::class)->parameters([
//      'ejemplares' => 'ejemplar',
//  ]);

require __DIR__.'/auth.php';
