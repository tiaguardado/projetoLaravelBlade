<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user is an super-admin.
     */
    public function before(User $user): ?bool
    {
        // Verifica se o utilizador é um super administrador
        if ($user->role === 'super-admin') {
            return true; // Admins can do everything
        }

        // Se não
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->role === 'admin') {
            return true; // Admins can view any user
        } else {
            return false; // Non-admins cannot view any users
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->isAdmin($user)) {
            return true; // Admins can view any user
        } else {
            return false; // Non-admins cannot view any users
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isAdmin($user)) {
            return true; // Admins can view any user
        } else {
            return false; // Non-admins cannot view any users
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //Ninguém pode deletar o super-admin
        if ($model->role === 'super-admin' || $model->role === 'admin') {
            return false;
        }

        //Admin pode apagar qualquer utilizador que não seja super-admin
        if ($user->role === 'admin') {
            return true;
        }

        return false;
    }



    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
