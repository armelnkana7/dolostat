<?php

namespace App\Services;

use App\Models\WeeklyCoverageReport;
use App\Models\Program;
use Illuminate\Pagination\Paginator;

class WeeklyCoverageReportService
{
    /**
     * List weekly coverage reports with pagination
     */
    public function list($filters = [], $withRelations = ['program', 'recordedBy', 'establishment'])
    {
        $query = WeeklyCoverageReport::query();

        // Auto-scope by establishment
        $establishmentId = session('establishment_id') ?? auth()->user()?->establishment_id;
        if ($establishmentId) {
            $query->where('establishment_id', $establishmentId);
        }

        // Apply filters
        if (!empty($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }

        if (!empty($filters['recorded_by_user_id'])) {
            $query->where('recorded_by_user_id', $filters['recorded_by_user_id']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('program', function ($q) use ($filters) {
                $q->whereHas('schoolClass', function ($sq) use ($filters) {
                    $sq->where('name', 'like', "%{$filters['search']}%");
                })->orWhereHas('subject', function ($sq) use ($filters) {
                    $sq->where('name', 'like', "%{$filters['search']}%");
                });
            });
        }

        // Eager load relations
        if (!empty($withRelations)) {
            $query->with($withRelations);
        }

        return $query->latest('created_at')->paginate(15);
    }

    /**
     * Find a specific coverage report
     */
    public function find($id, $withRelations = ['program', 'recordedBy', 'establishment'])
    {
        $query = WeeklyCoverageReport::query();

        if (!empty($withRelations)) {
            $query->with($withRelations);
        }

        return $query->findOrFail($id);
    }

    /**
     * Create a new coverage report
     */
    public function create($data)
    {
        // Import the helper
        $helper = app('App\Helpers\AcademicYearHelper');

        $data['establishment_id'] = session('establishment_id') ?? auth()->user()->establishment_id;
        $data['academic_year_id'] = $helper->getCurrentAcademicYearId();
        $data['recorded_by_user_id'] = auth()->id();

        return WeeklyCoverageReport::create($data);
    }

    /**
     * Update a coverage report
     */
    public function update($id, $data)
    {
        $report = $this->find($id);

        // Don't allow changing program or establishment
        unset($data['program_id'], $data['establishment_id']);

        $report->update($data);

        return $report;
    }

    /**
     * Delete a coverage report
     */
    public function delete($id)
    {
        $report = $this->find($id);
        $report->delete();

        return true;
    }

    /**
     * Get all reports for a program
     */
    public function getReportsByProgram($programId, $withRelations = ['recordedBy'])
    {
        $query = WeeklyCoverageReport::where('program_id', $programId);

        if (!empty($withRelations)) {
            $query->with($withRelations);
        }

        return $query->get();
    }
}
