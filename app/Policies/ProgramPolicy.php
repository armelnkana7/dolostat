<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;

class ProgramPolicy
{
    /**
     * Determine whether the user can view any programs
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the program
     */
    public function view(User $user, Program $program): bool
    {
        return $user->establishment_id === $program->establishment_id;
    }

    /**
     * Determine whether the user can create programs
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the program
     */
    public function update(User $user, Program $program): bool
    {
        return $user->establishment_id === $program->establishment_id && ($user->is_admin ?? false);
    }

    /**
     * Determine whether the user can delete the program
     */
    public function delete(User $user, Program $program): bool
    {
        return $user->is_admin ?? false;
    }
}
