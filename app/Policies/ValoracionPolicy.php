<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Valoracion;
use App\Models\Videojuego;
use Illuminate\Auth\Access\Response;

class ValoracionPolicy
{
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
    public function view(User $user, Valoracion $valoracion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Videojuego $videojuego): bool
    {
        return Valoracion::where('user_id', $user->id)
        ->where('valorable_id', $videojuego->id)
        ->where('valorable_type', Videojuego::class)
        ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Valoracion $valoracion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Valoracion $valoracion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Valoracion $valoracion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Valoracion $valoracion): bool
    {
        return false;
    }
}
