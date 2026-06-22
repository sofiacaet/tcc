<?php

namespace App\Policies;

use App\Models\Plano;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\PermissionController;

class PlanoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return PermissionController::isAuthorized('plano.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Plano $plano): bool
    {
        return PermissionController::isAuthorized('plano.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return PermissionController::isAuthorized('plano.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Plano $plano): bool
    {
        return PermissionController::isAuthorized('plano.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plano $plano): bool
    {
        return PermissionController::isAuthorized('plano.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Plano $plano): bool
    {
        return PermissionController::isAuthorized('plano.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Plano $plano): bool
    {
        return PermissionController::isAuthorized('plano.delete');
    }
}
