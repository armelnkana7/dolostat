<?php

namespace App\Livewire\Dashboard;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use App\Models\Program;
use Livewire\Component;

class Censor extends Component
{
    public function render()
    {
        $establishment_id = session('establishment_id') ?? auth()->user()->establishment_id;
        $academicYear = AcademicYear::where('establishment_id', $establishment_id)
            ->where('is_active', true)
            ->first();

        // Get statistics
        $totalClasses = SchoolClass::where('establishment_id', $establishment_id)->count();
        $totalPrograms = Program::where('establishment_id', $establishment_id)->count();

        $reportsQuery = WeeklyCoverageReport::where('establishment_id', $establishment_id);
        if ($academicYear) {
            $reportsQuery->where('academic_year_id', $academicYear->id);
        }

        $totalReports = $reportsQuery->count();
        $pendingReports = $totalReports;

        // Calculate coverage: sum of done hours / sum of planned hours
        $programsQuery = Program::where('establishment_id', $establishment_id);
        if ($academicYear) {
            $programsQuery->where('academic_year_id', $academicYear->id);
        }

        $totalPlannedHours = $programsQuery->sum('nbr_hours') ?? 1;

        $reportsHoursQuery = WeeklyCoverageReport::where('establishment_id', $establishment_id);
        if ($academicYear) {
            $reportsHoursQuery->where('academic_year_id', $academicYear->id);
        }

        $totalDoneHours = $reportsHoursQuery->sum('nbr_hours_done') ?? 0;
        $avgCoverage = $totalPlannedHours > 0 ? ($totalDoneHours / $totalPlannedHours) * 100 : 0;

        $stats = [
            'total_classes' => $totalClasses,
            'total_programs' => $totalPrograms,
            'total_reports' => $totalReports,
            'pending_reports' => $pendingReports,
            'avg_coverage' => round($avgCoverage, 2),
        ];

        // Get recent reports with relationships
        $recentReportsQuery = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->with(['program.subject', 'program.schoolClass']);

        if ($academicYear) {
            $recentReportsQuery->where('academic_year_id', $academicYear->id);
        }

        $recentReports = $recentReportsQuery
            ->orderBy('updated_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($report) {
                $planned = $report->program->nbr_hours ?? 1;
                $done = $report->nbr_hours_done ?? 0;
                $report->coverage_percentage = $planned > 0 ? ($done / $planned) * 100 : 0;
                return $report;
            });

        // Get classes by coverage percentage (for analysis)
        $classesByCoverageQuery = SchoolClass::where('establishment_id', $establishment_id)
            ->with(['programs' => function ($query) use ($academicYear) {
                if ($academicYear) {
                    $query->where('academic_year_id', $academicYear->id);
                }
            }]);

        $classesByCoverage = $classesByCoverageQuery
            ->get()
            ->map(function ($class) use ($academicYear) {
                $totalPlanned = $class->programs->sum('nbr_hours') ?? 1;

                // Calculate total done hours directly from programs' weekly reports
                $programIds = $class->programs->pluck('id');
                $totalDoneQuery = WeeklyCoverageReport::whereIn('program_id', $programIds);
                if ($academicYear) {
                    $totalDoneQuery->where('academic_year_id', $academicYear->id);
                }
                $totalDone = $totalDoneQuery->sum('nbr_hours_done') ?? 0;

                $coverage = $totalPlanned > 0 ? ($totalDone / $totalPlanned) * 100 : 0;
                return [
                    'name' => $class->name,
                    'coverage' => round($coverage, 2),
                ];
            })
            ->sortByDesc('coverage')
            ->take(10);

        return view('livewire.dashboard.censor', compact('stats', 'recentReports', 'classesByCoverage'));
    }
}
