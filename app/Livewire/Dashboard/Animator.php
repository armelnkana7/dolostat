<?php

namespace App\Livewire\Dashboard;

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

        // Get all programs for the animator's department and establishment
        $myPrograms = Program::where('establishment_id', $establishment_id)
            ->whereHas('subject', function ($query) use ($department_id) {
                $query->where('department_id', $department_id);
            })
            ->get();

        $totalPrograms = $myPrograms->count();
        $totalClasses = SchoolClass::where('establishment_id', $establishment_id)->distinct('id')->count();

        // Get coverage statistics for the animator's programs
        $avgCoverage = WeeklyCoverageReport::whereIn('program_id', $myPrograms->pluck('id'))
            ->avg('coverage_percentage') ?? 0;

        $totalReports = WeeklyCoverageReport::whereIn('program_id', $myPrograms->pluck('id'))->count();

        $stats = [
            'total_programs' => $totalPrograms,
            'total_classes' => $totalClasses,
            'total_reports' => $totalReports,
            'coverage_status' => round($avgCoverage, 2),
        ];

        // Get all classes (without filtering by department, as classes can have multiple departments)
        $myClasses = SchoolClass::where('establishment_id', $establishment_id)
            ->with(['programs' => function ($query) use ($department_id) {
                $query->whereHas('subject', function ($q) use ($department_id) {
                    $q->where('department_id', $department_id);
                });
            }])
            ->get();

        // Get recent reports for animator's programs
        $recentReports = WeeklyCoverageReport::whereIn('program_id', $myPrograms->pluck('id'))
            ->with(['program.subject', 'program.schoolClass'])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('livewire.dashboard.animator', compact('stats', 'myClasses', 'recentReports'));
    }
}
