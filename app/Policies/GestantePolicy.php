<?php

namespace App\Policies;

use App\Models\Gestante;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\PermissionController;

class GestantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return PermissionController::isAuthorized('gestante.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Gestante $gestante): bool
    {
        return PermissionController::isAuthorized('gestante.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return PermissionController::isAuthorized('gestante.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Gestante $gestante): bool
    {
        return PermissionController::isAuthorized('gestante.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Gestante $gestante): bool
    {
        return PermissionController::isAuthorized('gestante.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Gestante $gestante): bool
    {
        return PermissionController::isAuthorized('gestante.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Gestante $gestante): bool
    {
        return PermissionController::isAuthorized('gestante.delete');
    }
}
