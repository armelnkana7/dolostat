<?php

namespace App\Policies;

use App\Models\AcademicYear;
use App\Models\User;

class AcademicYearPolicy
{
    /**
     * Determine whether the user can view any academic years
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the academic year
     */
    public function view(User $user, AcademicYear $academicYear): bool
    {
        return $user->establishment_id === $academicYear->establishment_id || $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can create academic years
     */
    public function create(User $user): bool
    {
        return $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the academic year
     */
    public function update(User $user, AcademicYear $academicYear): bool
    {
        return $user->establishment_id === $academicYear->establishment_id || $user->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the academic year
     */
    public function delete(User $user, AcademicYear $academicYear): bool
    {
        return $user->is_admin ?? false;
    }
}
