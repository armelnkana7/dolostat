<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Pagination\Paginator;

class SubjectService
{
    /**
     * Retrieve list of subjects with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = Subject::query();

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
            $query = $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single subject by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\Subject|null
     */
    public function find(int $id, array $with = []): ?Subject
    {
        $query = Subject::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new subject
     *
     * @param array $data
     * @return \App\Models\Subject
     */
    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    /**
     * Update an existing subject
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Subject|null
     */
    public function update(int $id, array $data): ?Subject
    {
        $subject = Subject::find($id);
        if ($subject) {
            $subject->update($data);
        }
        return $subject;
    }

    /**
     * Delete a subject
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $subject = Subject::find($id);
        if ($subject) {
            return $subject->delete();
        }
        return false;
    }
}
