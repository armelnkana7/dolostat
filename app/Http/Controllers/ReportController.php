<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProgramExport;
use App\Services\ReportService;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\CoverageReportService;
use App\Services\CoverageReportExportService;

/**
 * ReportController
 * 
 * Requires: composer require maatwebsite/excel barryvdh/laravel-dompdf
 * 
 * Handles export of reports in various formats.
 */
class ReportController extends Controller
{
    public function __construct(private CoverageReportService $reportService, protected CoverageReportExportService $exportService) {}


    /**
     * Export programs for a school class as Excel
     */
    public function exportProgramsExcel($classeId)
    {
        $data = $this->reportService->prepareProgramData($classeId);
        $fileName = 'programs_' . ($data['class']?->name ?? 'export') . '.xlsx';

        return Excel::download(
            new ProgramExport($data['programs']),
            $fileName
        );
    }

    /**
     * Export programs for a school class as PDF
     */
    public function exportProgramPdf($classeId)
    {
        $data = $this->reportService->prepareProgramData($classeId);

        // This requires barryvdh/laravel-dompdf
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('exports.program', $data);

        $fileName = 'programs_' . ($data['class']?->name ?? 'export') . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Export weekly coverage for a program as PDF
     * 
     * TODO: Implement coverage report generation
     */
    public function exportWeeklyCoveragePdf($programId)
    {
        // Placeholder for weekly coverage report
        return response()->json(['message' => 'Not implemented yet'], 501);
    }

    public function coveragePdf(Request $request)
    {
        // récupère les mêmes filtres que Livewire en query string
        $filterType = $request->query('filter_type');
        $filterId   = $request->query('filter_id');

        // If user is animator, filter by their department
        $departmentId = null;
        if (auth()->user()->hasRole('animator')) {
            $departmentId = auth()->user()->department_id;
        }

        $data = match ($filterType) {
            'class' => $this->reportService->getCoverageByClass($filterId, $departmentId),
            'department' => $this->reportService->getCoverageByDepartment($filterId, $departmentId),
            'subject' => $this->reportService->getCoverageBySubject($filterId, $departmentId),
            'global' => [$this->reportService->getGlobalCoverage($departmentId)],
            default => [],
        };

        // exportToPdf doit retourner un Content (string) ou Response
        $response = $this->exportService->exportToPdf($data, $filterType);

        // Si exportToPdf retourne déjà une Response avec headers corrects, on la renvoie.
        return $response;
    }
    public function coverageExcel(Request $request)
    {
        // récupère les mêmes filtres que Livewire en query string
        $filterType = $request->query('filter_type');
        $filterId   = $request->query('filter_id');

        // If user is animator, filter by their department
        $departmentId = null;
        if (auth()->user()->hasRole('animator')) {
            $departmentId = auth()->user()->department_id;
        }

        $data = match ($filterType) {
            'class' => $this->reportService->getCoverageByClass($filterId, $departmentId),
            'department' => $this->reportService->getCoverageByDepartment($filterId, $departmentId),
            'subject' => $this->reportService->getCoverageBySubject($filterId, $departmentId),
            'global' => [$this->reportService->getGlobalCoverage($departmentId)],
            default => [],
        };

        // exportToPdf doit retourner un Content (string) ou Response
        $response = $this->exportService->exportToExcel($data, $filterType);

        // Si exportToPdf retourne déjà une Response avec headers corrects, on la renvoie.
        return $response;
    }

    /**
     * Export coverage report as CSV
     */
    public function coverageCsv(Request $request)
    {
        // récupère les mêmes filtres que Livewire en query string
        $filterType = $request->query('filter_type');
        $filterId   = $request->query('filter_id');

        // If user is animator, filter by their department
        $departmentId = null;
        if (auth()->user()->hasRole('animator')) {
            $departmentId = auth()->user()->department_id;
        }

        $data = match ($filterType) {
            'class' => $this->reportService->getCoverageByClass($filterId, $departmentId),
            'department' => $this->reportService->getCoverageByDepartment($filterId, $departmentId),
            'subject' => $this->reportService->getCoverageBySubject($filterId, $departmentId),
            'global' => [$this->reportService->getGlobalCoverage($departmentId)],
            default => [],
        };

        return $this->exportService->exportToCsv($data, $filterType);
    }
}
