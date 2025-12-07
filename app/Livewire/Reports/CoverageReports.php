<?php

namespace App\Livewire\Reports;

use App\Livewire\Traits\WithToasts;
use App\Services\CoverageReportService;
use App\Services\CoverageReportExportService;
use Livewire\Component;

class CoverageReports extends Component
{
    use WithToasts;

    protected CoverageReportService $reportService;
    protected CoverageReportExportService $exportService;
    public $filterType = 'class'; // class ou department
    public $filterId = null;

    public function boot(CoverageReportService $reportService, CoverageReportExportService $exportService)
    {
        $this->reportService = $reportService;
        $this->exportService = $exportService;
    }

    public function setFilter($type)
    {
        $this->filterType = $type;
        $this->filterId = null;
    }

    public function render()
    {
        try {
            // If user is animator, filter by their department
            $departmentId = null;
            if (auth()->user()->hasRole('animator')) {
                $departmentId = auth()->user()->department_id;
            }

            $data = match ($this->filterType) {
                'class' => $this->reportService->getCoverageByClass($this->filterId, $departmentId),
                'department' => $this->reportService->getCoverageByDepartment($this->filterId, $departmentId),
                'subject' => $this->reportService->getCoverageBySubject($this->filterId, $departmentId),
                default => collect([]),
            };

            $global = $this->reportService->getGlobalCoverage($departmentId);

            // Ensure global has all required keys with default values
            $global = array_merge([
                'coverage_percentage' => 0,
                'programs_count' => 0,
                'reports_count' => 0,
                'total_planned' => ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0],
                'total_done' => ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0],
            ], $global ?? []);

            return view('livewire.reports.coverage-reports', [
                'data' => $data,
                'global' => $global,
                'filterType' => $this->filterType,
            ]);
        } catch (\Exception $e) {
            $this->toastError('Erreur lors du chargement des rapports: ' . $e->getMessage(), 'Erreur');
            return view('livewire.reports.coverage-reports', [
                'data' => collect([]),
                'global' => [
                    'coverage_percentage' => 0,
                    'programs_count' => 0,
                    'reports_count' => 0,
                    'total_planned' => ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0],
                    'total_done' => ['hours' => 0, 'lesson' => 0, 'lesson_dig' => 0, 'tp' => 0, 'tp_dig' => 0],
                ],
                'filterType' => $this->filterType,
            ]);
        }
    }

    /**
     * Nettoyer et valider l'UTF-8
     */
    private function sanitizeUtf8($data)
    {
        if (is_array($data)) {
            return array_map(function ($item) {
                return $this->sanitizeUtf8($item);
            }, $data);
        }

        if (is_string($data)) {
            // Remove invalid UTF-8 sequences but preserve valid UTF-8
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            return iconv('UTF-8', 'UTF-8//IGNORE', $data);
        }

        return $data;
    }

    public function exportCsv()
    {
        try {
            // Build the query string with filter parameters
            $queryParams = http_build_query([
                'filter_type' => $this->filterType,
                'filter_id' => $this->filterId,
            ]);

            // Redirect browser to HTTP route that will handle the export
            $this->redirect(route('reports.coverage.csv') . '?' . $queryParams, navigate: false);
        } catch (\Exception $e) {
            $this->toastError('Erreur lors de l\'export CSV: ' . $e->getMessage(), 'Erreur');
        }
    }

    public function exportExcel()
    {
        try {
            // Build the query string with filter parameters
            $queryParams = http_build_query([
                'filter_type' => $this->filterType,
                'filter_id' => $this->filterId,
            ]);

            // Redirect browser to HTTP route that will handle the export
            $this->redirect(route('reports.coverage.excel') . '?' . $queryParams, navigate: false);
        } catch (\Exception $e) {
            $this->toastError('Erreur lors de l\'export Excel: ' . $e->getMessage(), 'Erreur');
        }
    }

    public function exportPdf()
    {
        try {
            // Build the query string with filter parameters
            $queryParams = http_build_query([
                'filter_type' => $this->filterType,
                'filter_id' => $this->filterId,
            ]);

            // Redirect browser to HTTP route that will handle the export
            $this->redirect(route('reports.coverage.pdf') . '?' . $queryParams, navigate: false);
        } catch (\Exception $e) {
            $this->toastError('Erreur lors de l\'export PDF: ' . $e->getMessage(), 'Erreur');
        }
    }
}
