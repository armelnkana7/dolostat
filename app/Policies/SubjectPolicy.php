<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    /**
     * Determine whether the user can view any subjects
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the subject
     */
    public function view(User $user, Subject $subject): bool
    {
        return $user->establishment_id === $subject->establishment_id;
    }

    /**
     * Determine whether the user can create subjects
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the subject
     */
    public function update(User $user, Subject $subject): bool
    {
        return $user->establishment_id === $subject->establishment_id && ($user->is_admin ?? false);
    }

    /**
     * Determine whether the user can delete the subject
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $user->is_admin ?? false;
    }
}
