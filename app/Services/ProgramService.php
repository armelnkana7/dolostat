<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Pagination\Paginator;

class ProgramService
{
    /**
     * Retrieve list of programs with optional filters and relations
     *
     * @param array $filters
     * @param array $withRelations Relations to eager load
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(array $filters = [], array $withRelations = [])
    {
        $query = Program::query();

        // Scope by establishment
        $establishmentId = $filters['establishment_id'] ?? session('establishment_id') ?? auth()->user()?->establishment_id;
        if ($establishmentId) {
            $query = $query->where('establishment_id', $establishmentId);
        }

        if (!empty($withRelations)) {
            $query = $query->with($withRelations);
        }

        if (!empty($filters['classe_id'])) {
            $query = $query->where('classe_id', $filters['classe_id']);
        }

        if (!empty($filters['subject_id'])) {
            $query = $query->where('subject_id', $filters['subject_id']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find a single program by ID with optional relations
     *
     * @param int $id
     * @param array $with Relations to eager load
     * @return \App\Models\Program|null
     */
    public function find(int $id, array $with = []): ?Program
    {
        $query = Program::query();

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->find($id);
    }

    /**
     * Create a new program
     *
     * @param array $data
     * @return \App\Models\Program
     */
    public function create(array $data): Program
    {
        // Auto-add establishment_id if not provided
        if (empty($data['establishment_id'])) {
            $data['establishment_id'] = session('establishment_id') ?? auth()->user()->establishment_id;
        }

        // Auto-add academic_year_id if not provided
        if (empty($data['academic_year_id'])) {
            $helper = app('App\Helpers\AcademicYearHelper');
            $data['academic_year_id'] = $helper->getCurrentAcademicYearId();
        }

        return Program::create($data);
    }

    /**
     * Update an existing program
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Program|null
     */
    public function update(int $id, array $data): ?Program
    {
        $program = Program::find($id);
        if ($program) {
            $program->update($data);
        }
        return $program;
    }

    /**
     * Delete a program
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $program = Program::find($id);
        if ($program) {
            return $program->delete();
        }
        return false;
    }

    /**
     * Get programs for a specific school class
     *
     * @param int $classeId
     * @param array $with Relations to eager load
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByClass(int $classeId, array $with = [])
    {
        $query = Program::where('classe_id', $classeId);

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->get();
    }
}
