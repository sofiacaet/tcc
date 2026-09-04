<?php

namespace App\Policies;

use App\Models\Orientacao;
use App\Models\User;
use App\Http\Controllers\PermissionController;

class OrientacaoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return PermissionController::isAuthorized('orientacao.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Orientacao $orientacao): bool
    {
        return PermissionController::isAuthorized('orientacao.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return PermissionController::isAuthorized('orientacao.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Orientacao $orientacao): bool
    {
        return PermissionController::isAuthorized('orientacao.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Orientacao $orientacao): bool
    {
        return PermissionController::isAuthorized('orientacao.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Orientacao $orientacao): bool
    {
        return PermissionController::isAuthorized('orientacao.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Orientacao $orientacao): bool
    {
        return PermissionController::isAuthorized('orientacao.delete');
    }
}