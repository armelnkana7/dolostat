<?php

namespace App\Livewire\Dashboard;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use App\Models\Program;
use Livewire\Component;

class Animator extends Component
{
    public function render()
    {
        $user = auth()->user();
        $department_id = $user->department_id;
        $establishment_id = session('establishment_id') ?? $user->establishment_id;

        $academicYear = AcademicYear::where('establishment_id', $establishment_id)
            ->where('is_active', true)
            ->first();

        // Get all programs for the animator's department and establishment
        $myProgramsQuery = Program::where('establishment_id', $establishment_id)
            ->whereHas('subject', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            });

        if ($academicYear) {
            $myProgramsQuery->where('academic_year_id', $academicYear->id);
        }

        $myPrograms = $myProgramsQuery->get();

        $totalPrograms = $myPrograms->count();
        $totalClasses = SchoolClass::where('establishment_id', $establishment_id)->distinct('id')->count();

        // Get coverage statistics for the animator's programs
        $reportsQuery = WeeklyCoverageReport::whereIn('program_id', $myPrograms->pluck('id'));
        if ($academicYear) {
            $reportsQuery->where('academic_year_id', $academicYear->id);
        }

        $totalReports = $reportsQuery->count();
        $totalDoneHours = $reportsQuery->sum('nbr_hours_done') ?? 0;
        $totalPlannedHours = $myPrograms->sum('nbr_hours') ?? 1;

        $avgCoverage = $totalPlannedHours > 0 ? ($totalDoneHours / $totalPlannedHours) * 100 : 0;

        $stats = [
            'total_programs' => $totalPrograms,
            'total_classes' => $totalClasses,
            'total_reports' => $totalReports,
            'coverage_status' => round($avgCoverage, 2),
        ];

        // Get all classes (without filtering by department, as classes can have multiple departments)
        $myClasses = SchoolClass::where('establishment_id', $establishment_id)
            ->with(['programs' => function ($query) use ($department_id, $academicYear) {
                $query->whereHas('subject', function ($q) use ($department_id) {
                    $q->where('department_id', $department_id);
                });
                if ($academicYear) {
                    $query->where('academic_year_id', $academicYear->id);
                }
            }])
            ->get();

        // Get recent reports for animator's programs
        $recentReportsQuery = WeeklyCoverageReport::whereIn('program_id', $myPrograms->pluck('id'))
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

        return view('livewire.dashboard.animator', compact('stats', 'myClasses', 'recentReports'));
    }
}
