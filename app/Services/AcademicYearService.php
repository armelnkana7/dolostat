<?php

namespace App\Services;

use App\Models\AcademicYear;
use Illuminate\Pagination\Paginator;

class AcademicYearService
{
    /**
     * Retrieve list of academic years with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = AcademicYear::query();

        // Scope by establishment if not in super admin mode
        $establishmentId = $filters['establishment_id'] ?? session('establishment_id') ?? auth()->user()?->establishment_id;
        if ($establishmentId) {
            $query = $query->where('establishment_id', $establishmentId);
        }

        if (!empty($withRelations)) {
            $query = $query->with($withRelations);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query = $query->where('title', 'like', "%{$search}%");
        }

        if (!empty($filters['is_active'])) {
            $query = $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single academic year by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\AcademicYear|null
     */
    public function find(int $id, array $with = []): ?AcademicYear
    {
        $query = AcademicYear::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new academic year
     *
     * @param array $data
     * @return \App\Models\AcademicYear
     */
    public function create(array $data): AcademicYear
    {
        return AcademicYear::create($data);
    }

    /**
     * Update an existing academic year
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\AcademicYear|null
     */
    public function update(int $id, array $data): ?AcademicYear
    {
        $academicYear = AcademicYear::find($id);
        if ($academicYear) {
            $academicYear->update($data);
        }
        return $academicYear;
    }

    /**
     * Delete an academic year
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $academicYear = AcademicYear::find($id);
        if ($academicYear) {
            return $academicYear->delete();
        }
        return false;
    }

    /**
     * Get the active academic year for an establishment
     *
     * @param int $establishmentId
     * @return \App\Models\AcademicYear|null
     */
    public function getActive(int $establishmentId): ?AcademicYear
    {
        return AcademicYear::where('establishment_id', $establishmentId)
            ->where('is_active', true)
            ->first();
    }
}
