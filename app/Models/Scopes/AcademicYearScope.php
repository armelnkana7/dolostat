<?php

namespace App\Models\Scopes;

use App\Helpers\AcademicYearHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AcademicYearScope implements Scope
{
    /**
     * Apply the scope.
     * Filtre par l'année académique courante
     */
    public function apply(Builder $builder, Model $model): void
    {
        $yearId = AcademicYearHelper::getCurrentAcademicYearId();

        if (is_numeric($yearId)) {
            // Use the table name to avoid ambiguous column reference
            $builder->where($model->getTable() . '.academic_year_id', $yearId);
        }
    }
}
