<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Program;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\WeeklyCoverageReport;
use Illuminate\Support\Collection;

class CoverageReportService
{
    /**
     * Obtenir les statistiques de couverture par département
     * Retourne une Collection d'objets Department enrichis avec les données de couverture
     */
    public function getCoverageByDepartment(?int $departmentId = null): Collection
    {
        $query = Department::query();

        if ($departmentId) {
            $query->where('id', $departmentId);
        }

        return $query->get()->map(function (Department $department) {
            // Charger les matières du département avec leurs programmes
            $subjects = $department->subjects()->get();

            if ($subjects->isEmpty()) {
                return null;
            }

            $totalPlanned = [
                'hours' => 0,
                'lesson' => 0,
                'lesson_dig' => 0,
                'tp' => 0,
                'tp_dig' => 0,
            ];

            $totalDone = [
                'hours' => 0,
                'lesson' => 0,
                'lesson_dig' => 0,
                'tp' => 0,
                'tp_dig' => 0,
            ];

            // Calculer les totaux pour tous les programmes des matières du département
            foreach ($subjects as $subject) {
                $programs = $subject->programs()->get();

                $totalPlanned['hours'] += $programs->sum('nbr_hours');
                $totalPlanned['lesson'] += $programs->sum('nbr_lesson');
                $totalPlanned['lesson_dig'] += $programs->sum('nbr_lesson_dig');
                $totalPlanned['tp'] += $programs->sum('nbr_tp');
                $totalPlanned['tp_dig'] += $programs->sum('nbr_tp_dig');

                foreach ($programs as $program) {
                    $reports = $program->weeklyCoverageReports()->get();
                    $totalDone['hours'] += $reports->sum('nbr_hours_done');
                    $totalDone['lesson'] += $reports->sum('nbr_lesson_done');
                    $totalDone['lesson_dig'] += $reports->sum('nbr_lesson_dig_done');
                    $totalDone['tp'] += $reports->sum('nbr_tp_done');
                    $totalDone['tp_dig'] += $reports->sum('nbr_tp_dig_done');
                }
            }

            // Enrichir l'objet Department avec les données calculées
            $department->total_planned = $totalPlanned;
            $department->total_done = $totalDone;
            $department->coverage_percentage = $this->calculateCoveragePercentage($totalPlanned, $totalDone);
            $department->subjects_count = $subjects->count();

            return $department;
        })->filter()->values();
    }

    /**
     * Obtenir les statistiques de couverture par classe
     * Retourne une Collection d'objets SchoolClass enrichis avec les données de couverture
     */
    public function getCoverageByClass(?int $classId = null): Collection
    {
        $query = SchoolClass::query();

        if ($classId) {
            $query->where('id', $classId);
        }

        return $query->get()->map(function (SchoolClass $class) {
            $programs = $class->programs()->get();

            if ($programs->isEmpty()) {
                return null;
            }

            $totalPlanned = [
                'hours' => $programs->sum('nbr_hours'),
                'lesson' => $programs->sum('nbr_lesson'),
                'lesson_dig' => $programs->sum('nbr_lesson_dig'),
                'tp' => $programs->sum('nbr_tp'),
                'tp_dig' => $programs->sum('nbr_tp_dig'),
            ];

            $totalDone = $this->getTotalDoneForClass($class);

            // Enrichir l'objet SchoolClass avec les données calculées
            $class->total_planned = $totalPlanned;
            $class->total_done = $totalDone;
            $class->coverage_percentage = $this->calculateCoveragePercentage($totalPlanned, $totalDone);
            $class->programs_count = $programs->count();

            return $class;
        })->filter()->values();
    }

    /**
     * Obtenir le total réalisé pour une classe
     */
    private function getTotalDoneForClass(SchoolClass $class): array
    {
        $programs = $class->programs()->get();

        $totalDone = [
            'hours' => 0,
            'lesson' => 0,
            'lesson_dig' => 0,
            'tp' => 0,
            'tp_dig' => 0,
        ];

        foreach ($programs as $program) {
            $reports = $program->weeklyCoverageReports()->get();
            $totalDone['hours'] += $reports->sum('nbr_hours_done');
            $totalDone['lesson'] += $reports->sum('nbr_lesson_done');
            $totalDone['lesson_dig'] += $reports->sum('nbr_lesson_dig_done');
            $totalDone['tp'] += $reports->sum('nbr_tp_done');
            $totalDone['tp_dig'] += $reports->sum('nbr_tp_dig_done');
        }

        return $totalDone;
    }

    /**
     * Obtenir les statistiques globales de couverture
     */
    public function getGlobalCoverage(): array
    {
        $programs = Program::all();

        $totalPlanned = [
            'hours' => $programs->sum('nbr_hours'),
            'lesson' => $programs->sum('nbr_lesson'),
            'lesson_dig' => $programs->sum('nbr_lesson_dig'),
            'tp' => $programs->sum('nbr_tp'),
            'tp_dig' => $programs->sum('nbr_tp_dig'),
        ];

        $reports = WeeklyCoverageReport::all();

        $totalDone = [
            'hours' => $reports->sum('nbr_hours_done'),
            'lesson' => $reports->sum('nbr_lesson_done'),
            'lesson_dig' => $reports->sum('nbr_lesson_dig_done'),
            'tp' => $reports->sum('nbr_tp_done'),
            'tp_dig' => $reports->sum('nbr_tp_dig_done'),
        ];

        $result = [
            'total_planned' => $totalPlanned,
            'total_done' => $totalDone,
            'coverage_percentage' => $this->calculateCoveragePercentage($totalPlanned, $totalDone),
            'programs_count' => $programs->count(),
            'reports_count' => $reports->count(),
        ];

        return $result;
    }

    /**
     * Calculer le pourcentage de couverture
     */
    private function calculateCoveragePercentage(array $planned, array $done): float
    {
        $totalPlanned = array_sum($planned);

        if ($totalPlanned == 0) {
            return 0;
        }

        $totalDone = array_sum($done);

        return min(100, round(($totalDone / $totalPlanned) * 100, 2));
    }
}
