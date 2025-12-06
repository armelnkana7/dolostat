<?php

namespace App\Livewire\Dashboard;

use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use App\Models\Program;
use App\Models\Subject;
use Livewire\Component;

class Censor extends Component
{
    public function render()
    {
        $establishment_id = session('establishment_id') ?? auth()->user()->establishment_id;

        // Get statistics
        $totalClasses = SchoolClass::where('establishment_id', $establishment_id)->count();
        $totalPrograms = Program::where('establishment_id', $establishment_id)->count();
        $totalReports = WeeklyCoverageReport::where('establishment_id', $establishment_id)->count();

        // Calculate reports with coverage
        $reportsWithCoverage = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->where('coverage_percentage', '>', 0)
            ->count();

        $pendingReports = $totalReports - $reportsWithCoverage;

        $avgCoverage = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->avg('coverage_percentage') ?? 0;

        $stats = [
            'total_classes' => $totalClasses,
            'total_programs' => $totalPrograms,
            'total_reports' => $totalReports,
            'pending_reports' => $pendingReports,
            'avg_coverage' => round($avgCoverage, 2),
        ];

        // Get recent reports with relationships
        $recentReports = WeeklyCoverageReport::where('establishment_id', $establishment_id)
            ->with(['program.subject', 'program.schoolClass', 'program.academicYear'])
            ->orderBy('updated_at', 'desc')
            ->take(15)
            ->get();

        // Get classes by coverage percentage (for analysis)
        $classesByCoverage = SchoolClass::where('establishment_id', $establishment_id)
            ->with(['programs' => function ($query) {
                $query->with(['weeklyReports' => function ($q) {
                    $q->select('program_id')->distinct();
                }]);
            }])
            ->get()
            ->map(function ($class) {
                $avgCov = $class->programs
                    ->flatMap(fn($p) => $p->weeklyReports)
                    ->avg('coverage_percentage') ?? 0;
                return [
                    'name' => $class->name,
                    'coverage' => round($avgCov, 2),
                ];
            })
            ->sortByDesc('coverage')
            ->take(10);

        return view('livewire.dashboard.censor', compact('stats', 'recentReports', 'classesByCoverage'));
    }
}
