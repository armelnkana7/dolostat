<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyCoverageReport;

class WeeklyCoverageReportPolicy
{
    /**
     * Determine if the user can view any coverage reports
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view a specific coverage report
     */
    public function view(User $user, WeeklyCoverageReport $report): bool
    {
        return $user->establishment_id === $report->establishment_id;
    }

    /**
     * Determine if the user can create a coverage report
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update a coverage report
     */
    public function update(User $user, WeeklyCoverageReport $report): bool
    {
        return $user->establishment_id === $report->establishment_id;
    }

    /**
     * Determine if the user can delete a coverage report
     */
    public function delete(User $user, WeeklyCoverageReport $report): bool
    {
        return $user->establishment_id === $report->establishment_id;
    }
}
