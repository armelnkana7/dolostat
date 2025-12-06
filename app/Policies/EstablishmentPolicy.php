<?php

namespace App\Policies;

use App\Models\Establishment;
use App\Models\User;

class EstablishmentPolicy
{
    /**
     * Determine whether the user can view any establishments
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the establishment
     */
    public function view(User $user, Establishment $establishment): bool
    {
        return $user->establishment_id === $establishment->id || $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can create establishments
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the establishment
     */
    public function update(User $user, Establishment $establishment): bool
    {
        return $user->establishment_id === $establishment->id || $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the establishment
     */
    public function delete(User $user, Establishment $establishment): bool
    {
        return $user->is_admin ?? false;
    }
}
