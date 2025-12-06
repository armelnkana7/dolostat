<?php

namespace App\Policies;

use App\Models\SchoolClass;
use App\Models\User;

class SchoolClassPolicy
{
    /**
     * Determine whether the user can view any school classes
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the school class
     */
    public function view(User $user, SchoolClass $schoolClass): bool
    {
        return $user->establishment_id === $schoolClass->establishment_id;
    }

    /**
     * Determine whether the user can create school classes
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the school class
     */
    public function update(User $user, SchoolClass $schoolClass): bool
    {
        return $user->establishment_id === $schoolClass->establishment_id && ($user->is_admin ?? false);
    }

    /**
     * Determine whether the user can delete the school class
     */
    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return $user->is_admin ?? false;
    }
}
