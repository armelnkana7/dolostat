<?php

namespace App\Services;

use App\Models\Program;

/**
 * ReportService - Handles report generation and exports
 * 
 * Note: This service assumes the following packages are installed:
 * - maatwebsite/excel (for Excel exports)
 * - barryvdh/laravel-dompdf (for PDF exports)
 * 
 * Install with:
 * composer require maatwebsite/excel barryvdh/laravel-dompdf
 */
class ReportService
{
    /**
     * Get programs for a specific school class
     *
     * @param int $classeId
     * @param array $with Relations to eager load
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProgramsForClass(int $classeId, array $with = ['establishment', 'subject'])
    {
        return Program::where('classe_id', $classeId)
            ->with($with)
            ->get();
    }

    /**
     * Prepare program data for export
     *
     * @param int $classeId
     * @return array
     */
    public function prepareProgramData(int $classeId): array
    {
        $programs = $this->getProgramsForClass($classeId);

        return [
            'programs' => $programs,
            'class' => $programs->first()?->schoolClass,
            'establishment' => $programs->first()?->establishment,
        ];
    }

    /**
     * Calculate coverage for a specific program
     * 
     * Returns an array with planned vs. done metrics and coverage percentages
     *
     * @param int $programId
     * @return array
     */
    public function computeCoverageForProgram(int $programId): array
    {
        $program = Program::with('weeklyCoverageReports')->findOrFail($programId);

        // Sum done metrics from all weekly reports
        $totalDone = [
            'nbr_hours_done' => 0,
            'nbr_lesson_done' => 0,
            'nbr_lesson_dig_done' => 0,
            'nbr_tp_done' => 0,
            'nbr_tp_dig_done' => 0,
        ];

        foreach ($program->weeklyCoverageReports as $report) {
            $totalDone['nbr_hours_done'] += $report->nbr_hours_done;
            $totalDone['nbr_lesson_done'] += $report->nbr_lesson_done;
            $totalDone['nbr_lesson_dig_done'] += $report->nbr_lesson_dig_done;
            $totalDone['nbr_tp_done'] += $report->nbr_tp_done;
            $totalDone['nbr_tp_dig_done'] += $report->nbr_tp_dig_done;
        }

        // Calculate coverage percentages
        $coverage = [
            'nbr_hours' => [
                'planned' => $program->nbr_hours ?? 0,
                'done' => $totalDone['nbr_hours_done'],
                'percentage' => ($program->nbr_hours > 0) ? round(($totalDone['nbr_hours_done'] / $program->nbr_hours) * 100, 2) : 0,
            ],
            'nbr_lesson' => [
                'planned' => $program->nbr_lesson ?? 0,
                'done' => $totalDone['nbr_lesson_done'],
                'percentage' => ($program->nbr_lesson > 0) ? round(($totalDone['nbr_lesson_done'] / $program->nbr_lesson) * 100, 2) : 0,
            ],
            'nbr_lesson_dig' => [
                'planned' => $program->nbr_lesson_dig ?? 0,
                'done' => $totalDone['nbr_lesson_dig_done'],
                'percentage' => ($program->nbr_lesson_dig > 0) ? round(($totalDone['nbr_lesson_dig_done'] / $program->nbr_lesson_dig) * 100, 2) : 0,
            ],
            'nbr_tp' => [
                'planned' => $program->nbr_tp ?? 0,
                'done' => $totalDone['nbr_tp_done'],
                'percentage' => ($program->nbr_tp > 0) ? round(($totalDone['nbr_tp_done'] / $program->nbr_tp) * 100, 2) : 0,
            ],
            'nbr_tp_dig' => [
                'planned' => $program->nbr_tp_dig ?? 0,
                'done' => $totalDone['nbr_tp_dig_done'],
                'percentage' => ($program->nbr_tp_dig > 0) ? round(($totalDone['nbr_tp_dig_done'] / $program->nbr_tp_dig) * 100, 2) : 0,
            ],
        ];

        // Overall coverage percentage (weighted average of all non-zero planned metrics)
        $totalPlanned = array_sum([
            $program->nbr_hours ?? 0,
            $program->nbr_lesson ?? 0,
            $program->nbr_lesson_dig ?? 0,
            $program->nbr_tp ?? 0,
            $program->nbr_tp_dig ?? 0,
        ]);

        $totalDoneSum = array_sum([
            $totalDone['nbr_hours_done'],
            $totalDone['nbr_lesson_done'],
            $totalDone['nbr_lesson_dig_done'],
            $totalDone['nbr_tp_done'],
            $totalDone['nbr_tp_dig_done'],
        ]);

        $overallPercentage = ($totalPlanned > 0) ? round(($totalDoneSum / $totalPlanned) * 100, 2) : 0;

        return [
            'program_id' => $programId,
            'program_name' => $program->subject?->name ?? 'N/A',
            'class_name' => $program->schoolClass?->name ?? 'N/A',
            'coverage' => $coverage,
            'overall_percentage' => $overallPercentage,
            'total_planned' => $totalPlanned,
            'total_done' => $totalDoneSum,
        ];
    }

    /**
     * Calculate coverage for all programs in a school class
     * 
     * Returns aggregated coverage data
     *
     * @param int $classeId
     * @return array
     */
    public function computeCoverageForClass(int $classeId): array
    {
        $programs = Program::where('classe_id', $classeId)
            ->with('weeklyCoverageReports', 'subject', 'schoolClass')
            ->get();


        $programsCoverage = [];
        $totalMetrics = [
            'nbr_hours' => ['planned' => 0, 'done' => 0],
            'nbr_lesson' => ['planned' => 0, 'done' => 0],
            'nbr_lesson_dig' => ['planned' => 0, 'done' => 0],
            'nbr_tp' => ['planned' => 0, 'done' => 0],
            'nbr_tp_dig' => ['planned' => 0, 'done' => 0],
        ];

        foreach ($programs as $program) {
            $coverage = $this->computeCoverageForProgram($program->id);
            $programsCoverage[] = $coverage;

            // Aggregate metrics
            foreach (['nbr_hours', 'nbr_lesson', 'nbr_lesson_dig', 'nbr_tp', 'nbr_tp_dig'] as $metric) {
                $totalMetrics[$metric]['planned'] += $coverage['coverage'][$metric]['planned'];
                $totalMetrics[$metric]['done'] += $coverage['coverage'][$metric]['done'];
            }
        }

        // dd($programsCoverage, $programs);

        // Calculate aggregated coverage percentages
        $aggregatedCoverage = [];
        foreach (['nbr_hours', 'nbr_lesson', 'nbr_lesson_dig', 'nbr_tp', 'nbr_tp_dig'] as $metric) {
            $planned = $totalMetrics[$metric]['planned'];
            $done = $totalMetrics[$metric]['done'];
            $aggregatedCoverage[$metric] = [
                'planned' => $planned,
                'done' => $done,
                'percentage' => ($planned > 0) ? round(($done / $planned) * 100, 2) : 0,
            ];
        }

        $totalPlanned = array_sum(array_column($totalMetrics, 'planned'));
        $totalDone = array_sum(array_column($totalMetrics, 'done'));
        $overallPercentage = ($totalPlanned > 0) ? round(($totalDone / $totalPlanned) * 100, 2) : 0;

        return [
            'class_id' => $classeId,
            'class_name' => $programs->first()?->schoolClass?->name ?? 'N/A',
            'programs_count' => $programs->count(),
            'programs_coverage' => $programsCoverage,
            'aggregated_coverage' => $aggregatedCoverage,
            'overall_percentage' => $overallPercentage,
            'total_planned' => $totalPlanned,
            'total_done' => $totalDone,
        ];
    }
}
