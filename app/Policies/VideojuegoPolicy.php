<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Valoracion;
use App\Models\Videojuego;
use Illuminate\Auth\Access\Response;

class VideojuegoPolicy
{
    public function valorar(User $user, Videojuego $videojuego) {
        $valoracion_existe = Valoracion::where('user_id', $user->id)
        ->where('valorable_id', $videojuego->id)
        ->where('valorable_type', Videojuego::class)
        ->exists();

        return !$valoracion_existe;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Videojuego $videojuego): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Videojuego $videojuego): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Videojuego $videojuego): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Videojuego $videojuego): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Videojuego $videojuego): bool
    {
        return false;
    }
}
