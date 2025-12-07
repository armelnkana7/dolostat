<?php

namespace App\Livewire\Dashboard;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Department;
use Livewire\Component;

class Admin extends Component
{
    public function render()
    {
        $establishment_id = session('establishment_id') ?? auth()->user()->establishment_id;
        $academicYear = AcademicYear::where('establishment_id', $establishment_id)
            ->where('is_active', true)
            ->first();

        // Get all programs for the establishment
        $programsQuery = Program::where('establishment_id', $establishment_id);
        if ($academicYear) {
            $programsQuery->where('academic_year_id', $academicYear->id);
        }

        $allPrograms = $programsQuery->count();
        $totalPlannedHours = $programsQuery->sum('nbr_hours') ?? 0;

        // Get coverage statistics
        $reportsQuery = WeeklyCoverageReport::where('establishment_id', $establishment_id);
        if ($academicYear) {
            $reportsQuery->where('academic_year_id', $academicYear->id);
        }

        $totalReports = $reportsQuery->count();
        $totalDoneHours = $reportsQuery->sum('nbr_hours_done') ?? 0;
        $avgCoverage = $totalPlannedHours > 0 ? ($totalDoneHours / $totalPlannedHours) * 100 : 0;

        $stats = [
            'total_classes' => SchoolClass::where('establishment_id', $establishment_id)->count(),
            'total_departments' => Department::where('establishment_id', $establishment_id)->count(),
            'total_subjects' => Subject::where('establishment_id', $establishment_id)->count(),
            'total_programs' => $allPrograms,
            'total_planned_hours' => $totalPlannedHours,
            'total_reports' => $totalReports,
            'avg_coverage' => round($avgCoverage, 2),
        ];

        // Get recent reports
        $recentReportsQuery = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->with(['program.subject', 'program.schoolClass']);

        if ($academicYear) {
            $recentReportsQuery->where('academic_year_id', $academicYear->id);
        }

        $recentReports = $recentReportsQuery
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($report) {
                $planned = $report->program->nbr_hours ?? 1;
                $done = $report->nbr_hours_done ?? 0;
                $report->coverage_percentage = $planned > 0 ? ($done / $planned) * 100 : 0;
                return $report;
            });

        return view('livewire.dashboard.admin', compact('stats', 'recentReports'));
    }
}
