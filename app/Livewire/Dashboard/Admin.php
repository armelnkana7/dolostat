<?php

namespace App\Livewire\Dashboard;

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

        // Get all programs for the establishment
        $allPrograms = Program::where('establishment_id', $establishment_id)->count();
        $totalPlannedHours = Program::where('establishment_id', $establishment_id)
            ->sum('volume_horaire') ?? 0;

        // Get coverage statistics
        $totalReports = WeeklyCoverageReport::where('establishment_id', $establishment_id)->count();
        $avgCoverage = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->avg('coverage_percentage') ?? 0;

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
        $recentReports = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->with(['program.subject', 'program.schoolClass'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('livewire.dashboard.admin', compact('stats', 'recentReports'));
    }
}
