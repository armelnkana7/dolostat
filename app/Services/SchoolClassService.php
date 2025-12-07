<?php

namespace App\Services;

use App\Models\SchoolClass;
use Illuminate\Pagination\Paginator;

class SchoolClassService
{
    /**
     * Retrieve list of school classes with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = SchoolClass::query();

        // Scope by establishment
        $establishmentId = $filters['establishment_id'] ?? session('establishment_id') ?? auth()->user()?->establishment_id;
        if ($establishmentId) {
            $query = $query->where('establishment_id', $establishmentId);
        }

        if (!empty($withRelations)) {
            $query = $query->with($withRelations);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query = $query->where('name', 'like', "%{$search}%");
        }

        // Filter by department: get classes that have programs with subjects in the department
        if (!empty($filters['department_id'])) {
            $query = $query->whereHas('programs.subject', function ($q) use ($filters) {
                $q->where('department_id', $filters['department_id']);
            })->distinct();
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single school class by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\SchoolClass|null
     */
    public function find(int $id, array $with = []): ?SchoolClass
    {
        $query = SchoolClass::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new school class
     *
     * @param array $data
     * @return \App\Models\SchoolClass
     */
    public function create(array $data): SchoolClass
    {
        return SchoolClass::create($data);
    }

    /**
     * Update an existing school class
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\SchoolClass|null
     */
    public function update(int $id, array $data): ?SchoolClass
    {
        $schoolClass = SchoolClass::find($id);
        if ($schoolClass) {
            $schoolClass->update($data);
        }
        return $schoolClass;
    }

    /**
     * Delete a school class
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $schoolClass = SchoolClass::find($id);
        if ($schoolClass) {
            return $schoolClass->delete();
        }
        return false;
    }
}
