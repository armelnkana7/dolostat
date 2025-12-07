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
     * 
     * @param int|null $departmentId ID spécifique du département, ou null pour tous
     * @param int|null $filterDepartmentId Département de l'utilisateur pour filtrer (si animateur)
     */
    public function getCoverageByDepartment(?int $departmentId = null, ?int $filterDepartmentId = null): Collection
    {
        $query = Department::query();

        // Si on a un département de filtre (utilisateur animateur), limiter à celui-ci
        if ($filterDepartmentId) {
            $query->where('id', $filterDepartmentId);
        }
        // Sinon, si un département spécifique est demandé
        elseif ($departmentId) {
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
     * 
     * @param int|null $classId ID spécifique de la classe, ou null pour tous
     * @param int|null $departmentId Département pour filtrer (si animateur)
     */
    public function getCoverageByClass(?int $classId = null, ?int $departmentId = null): Collection
    {
        $query = SchoolClass::query();

        if ($classId) {
            $query->where('id', $classId);
        }

        return $query->get()->map(function (SchoolClass $class) use ($departmentId) {
            // Filtrer les programmes par département si nécessaire
            $programsQuery = $class->programs();
            if ($departmentId) {
                $programsQuery = $programsQuery->whereHas('subject', function ($q) use ($departmentId) {
                    $q->where('department_id', $departmentId);
                });
            }
            $programs = $programsQuery->get();

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

            $totalDone = $this->getTotalDoneForClass($class, $departmentId);

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
     * 
     * @param SchoolClass $class
     * @param int|null $departmentId Département pour filtrer (si animateur)
     */
    private function getTotalDoneForClass(SchoolClass $class, ?int $departmentId = null): array
    {
        $programsQuery = $class->programs();
        if ($departmentId) {
            $programsQuery = $programsQuery->whereHas('subject', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        $programs = $programsQuery->get();

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
     * 
     * @param int|null $departmentId Département pour filtrer (si animateur)
     */
    public function getGlobalCoverage(?int $departmentId = null): array
    {
        // Si un département est spécifié, filtrer les programmes et rapports
        $programsQuery = Program::query();
        if ($departmentId) {
            $programsQuery = $programsQuery->whereHas('subject', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        $programs = $programsQuery->get();

        $totalPlanned = [
            'hours' => $programs->sum('nbr_hours'),
            'lesson' => $programs->sum('nbr_lesson'),
            'lesson_dig' => $programs->sum('nbr_lesson_dig'),
            'tp' => $programs->sum('nbr_tp'),
            'tp_dig' => $programs->sum('nbr_tp_dig'),
        ];

        $reportsQuery = WeeklyCoverageReport::query();
        if ($departmentId) {
            $reportsQuery = $reportsQuery->whereHas('program.subject', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        $reports = $reportsQuery->get();

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
     * Obtenir les statistiques de couverture par matière
     * Organisé par classe et niveau
     * Retourne une Collection de Subject avec couverture par classe
     * 
     * @param int|null $subjectId ID spécifique de la matière, ou null pour tous
     * @param int|null $departmentId Département pour filtrer (si animateur)
     */
    public function getCoverageBySubject(?int $subjectId = null, ?int $departmentId = null): Collection
    {
        $query = Subject::query();

        if ($subjectId) {
            $query->where('id', $subjectId);
        }

        // Si un département est spécifié, filtrer les matières
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        return $query->get()->map(function (Subject $subject) {
            // Obtenir tous les programmes de cette matière
            $programs = $subject->programs()->with('schoolClass', 'weeklyCoverageReports')->get();

            if ($programs->isEmpty()) {
                return null;
            }

            // Grouper les programmes par classe et niveau
            $programsByClass = $programs->groupBy(function ($program) {
                return $program->schoolClass->id;
            })->map(function ($classPrograms) {
                $firstClass = $classPrograms->first()?->schoolClass;

                $totalPlanned = [
                    'hours' => $classPrograms->sum('nbr_hours'),
                    'lesson' => $classPrograms->sum('nbr_lesson'),
                    'lesson_dig' => $classPrograms->sum('nbr_lesson_dig'),
                    'tp' => $classPrograms->sum('nbr_tp'),
                    'tp_dig' => $classPrograms->sum('nbr_tp_dig'),
                ];

                $totalDone = [
                    'hours' => 0,
                    'lesson' => 0,
                    'lesson_dig' => 0,
                    'tp' => 0,
                    'tp_dig' => 0,
                ];

                // Calculer les totaux réalisés
                foreach ($classPrograms as $program) {
                    $reports = $program->weeklyCoverageReports;
                    $totalDone['hours'] += $reports->sum('nbr_hours_done');
                    $totalDone['lesson'] += $reports->sum('nbr_lesson_done');
                    $totalDone['lesson_dig'] += $reports->sum('nbr_lesson_dig_done');
                    $totalDone['tp'] += $reports->sum('nbr_tp_done');
                    $totalDone['tp_dig'] += $reports->sum('nbr_tp_dig_done');
                }

                return (object) [
                    'class_id' => $firstClass->id,
                    'class_name' => $firstClass->name,
                    'level' => $firstClass->level,
                    'programs_count' => $classPrograms->count(),
                    'total_planned' => $totalPlanned,
                    'total_done' => $totalDone,
                    'coverage_percentage' => $this->calculateCoveragePercentage($totalPlanned, $totalDone),
                ];
            });

            // Enrichir l'objet Subject avec les données calculées
            $subject->classes_coverage = $programsByClass->values();
            $subject->classes_count = $programsByClass->count();

            // Calculer les totaux globaux pour la matière
            $globalTotalPlanned = [
                'hours' => $programs->sum('nbr_hours'),
                'lesson' => $programs->sum('nbr_lesson'),
                'lesson_dig' => $programs->sum('nbr_lesson_dig'),
                'tp' => $programs->sum('nbr_tp'),
                'tp_dig' => $programs->sum('nbr_tp_dig'),
            ];

            $globalTotalDone = [
                'hours' => 0,
                'lesson' => 0,
                'lesson_dig' => 0,
                'tp' => 0,
                'tp_dig' => 0,
            ];

            foreach ($programs as $program) {
                $reports = $program->weeklyCoverageReports;
                $globalTotalDone['hours'] += $reports->sum('nbr_hours_done');
                $globalTotalDone['lesson'] += $reports->sum('nbr_lesson_done');
                $globalTotalDone['lesson_dig'] += $reports->sum('nbr_lesson_dig_done');
                $globalTotalDone['tp'] += $reports->sum('nbr_tp_done');
                $globalTotalDone['tp_dig'] += $reports->sum('nbr_tp_dig_done');
            }

            $subject->total_planned = $globalTotalPlanned;
            $subject->total_done = $globalTotalDone;
            $subject->coverage_percentage = $this->calculateCoveragePercentage($globalTotalPlanned, $globalTotalDone);
            $subject->programs_count = $programs->count();

            return $subject;
        })->filter()->values();
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
