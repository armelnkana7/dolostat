<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Pagination\Paginator;

class DepartmentService
{
    /**
     * Retrieve list of departments with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = Department::query();

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

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single department by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\Department|null
     */
    public function find(int $id, array $with = []): ?Department
    {
        $query = Department::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new department
     *
     * @param array $data
     * @return \App\Models\Department
     */
    public function create(array $data): Department
    {
        return Department::create($data);
    }

    /**
     * Update an existing department
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Department|null
     */
    public function update(int $id, array $data): ?Department
    {
        $department = Department::find($id);
        if ($department) {
            $department->update($data);
        }
        return $department;
    }

    /**
     * Delete a department
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $department = Department::find($id);
        if ($department) {
            return $department->delete();
        }
        return false;
    }
}
