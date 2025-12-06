<?php

namespace App\Services;

use App\Models\Establishment;
use Illuminate\Pagination\Paginator;

class EstablishmentService
{
    /**
     * Retrieve list of establishments with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = Establishment::query();

        if (!empty($withRelations)) {
            $query = $query->with($withRelations);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query = $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single establishment by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\Establishment|null
     */
    public function find(int $id, array $with = []): ?Establishment
    {
        $query = Establishment::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new establishment
     *
     * @param array $data
     * @return \App\Models\Establishment
     */
    public function create(array $data): Establishment
    {
        return Establishment::create($data);
    }

    /**
     * Update an existing establishment
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Establishment|null
     */
    public function update(int $id, array $data): ?Establishment
    {
        $establishment = Establishment::find($id);
        if ($establishment) {
            $establishment->update($data);
        }
        return $establishment;
    }

    /**
     * Delete an establishment
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $establishment = Establishment::find($id);
        if ($establishment) {
            return $establishment->delete();
        }
        return false;
    }
}
