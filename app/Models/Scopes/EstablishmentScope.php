<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EstablishmentScope implements Scope
{
    /**
     * Apply the scope.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (session()->has('establishment_id')) {
            $establishmentId = session('establishment_id');
            if (is_numeric($establishmentId)) {
                $builder->where($model->getTable() . '.establishment_id', '=', (int) $establishmentId);
            }
        }
    }
}
