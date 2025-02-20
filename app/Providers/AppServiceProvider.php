<?php

namespace App\Providers;

use App\Models\Pelicula;
use App\Models\User;
use App\Models\Valoracion;
use App\Models\Videojuego;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-valoracion', function (User $user, Valoracion $valoracion) {
            return $user->id === $valoracion->user->id;
        });

        Gate::define('anyadir-genero', function (User $user) {
            return $user->name == 'Admin';
        });

        Gate::define('pelicula-valorada', function (User $user, Pelicula $pelicula) {
            return Valoracion::where('user_id', $user->id)
            ->where('valorable_id', $pelicula->id)
            ->where('valorable_type', Pelicula::class)
            ->exists();
        });

        Gate::define('videojuego-valorado', function (User $user, Videojuego $videojuego) {
            return Valoracion::where('user_id', $user->id)
            ->where('valorable_id', $videojuego->id)
            ->where('valorable_type', Videojuego::class)
            ->exists();
        });
    }
}
