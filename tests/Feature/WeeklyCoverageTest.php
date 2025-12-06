<?php

namespace Tests\Feature;

use App\Models\Establishment;
use App\Models\Program;
use App\Models\WeeklyCoverageReport;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyCoverageTest extends TestCase
{
    use RefreshDatabase;

    protected Establishment $establishment;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->establishment = Establishment::factory()->create();
        $this->user = User::factory()->create(['establishment_id' => $this->establishment->id]);
    }

    /**
     * Test creating a weekly coverage report
     */
    public function test_can_create_weekly_coverage_report()
    {
        $program = Program::factory()->create(['establishment_id' => $this->establishment->id]);

        $report = WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program->id,
            'recorded_by_user_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('weekly_coverage_reports', [
            'id' => $report->id,
            'program_id' => $program->id,
            'establishment_id' => $this->establishment->id,
        ]);
    }

    /**
     * Test computing coverage for a program
     */
    public function test_compute_coverage_for_program()
    {
        $program = Program::factory()->create([
            'establishment_id' => $this->establishment->id,
            'nbr_hours' => 40,
            'nbr_lesson' => 30,
            'nbr_lesson_dig' => 15,
            'nbr_tp' => 10,
            'nbr_tp_dig' => 8,
        ]);

        // Create multiple reports
        WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program->id,
            'recorded_by_user_id' => $this->user->id,
            'nbr_hours_done' => 20,
            'nbr_lesson_done' => 15,
            'nbr_lesson_dig_done' => 7,
            'nbr_tp_done' => 5,
            'nbr_tp_dig_done' => 4,
        ]);

        WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program->id,
            'recorded_by_user_id' => $this->user->id,
            'nbr_hours_done' => 20,
            'nbr_lesson_done' => 15,
            'nbr_lesson_dig_done' => 8,
            'nbr_tp_done' => 5,
            'nbr_tp_dig_done' => 4,
        ]);

        $reportService = new ReportService();
        $coverage = $reportService->computeCoverageForProgram($program->id);

        // Verify totals
        $this->assertEquals(40, $coverage['coverage']['nbr_hours']['done']);
        $this->assertEquals(30, $coverage['coverage']['nbr_lesson']['done']);
        $this->assertEquals(15, $coverage['coverage']['nbr_lesson_dig']['done']);
        $this->assertEquals(10, $coverage['coverage']['nbr_tp']['done']);
        $this->assertEquals(8, $coverage['coverage']['nbr_tp_dig']['done']);

        // Verify percentages
        $this->assertEquals(100, $coverage['coverage']['nbr_hours']['percentage']);
        $this->assertEquals(100, $coverage['coverage']['nbr_lesson']['percentage']);
        $this->assertEquals(100, $coverage['coverage']['nbr_lesson_dig']['percentage']);
        $this->assertEquals(100, $coverage['coverage']['nbr_tp']['percentage']);
        $this->assertEquals(100, $coverage['coverage']['nbr_tp_dig']['percentage']);

        // Verify overall percentage
        $this->assertEquals(100, $coverage['overall_percentage']);
    }

    /**
     * Test partial coverage
     */
    public function test_partial_coverage_calculation()
    {
        $program = Program::factory()->create([
            'establishment_id' => $this->establishment->id,
            'nbr_hours' => 40,
            'nbr_lesson' => 30,
            'nbr_lesson_dig' => 15,
            'nbr_tp' => 10,
            'nbr_tp_dig' => 8,
        ]);

        WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program->id,
            'recorded_by_user_id' => $this->user->id,
            'nbr_hours_done' => 10,
            'nbr_lesson_done' => 10,
            'nbr_lesson_dig_done' => 5,
            'nbr_tp_done' => 3,
            'nbr_tp_dig_done' => 2,
        ]);

        $reportService = new ReportService();
        $coverage = $reportService->computeCoverageForProgram($program->id);

        $this->assertEquals(25, $coverage['coverage']['nbr_hours']['percentage']);
        $this->assertEquals(33.33, $coverage['coverage']['nbr_lesson']['percentage']);
    }

    /**
     * Test computing coverage for a class
     */
    public function test_compute_coverage_for_class()
    {
        $class = \App\Models\SchoolClass::factory()->create(['establishment_id' => $this->establishment->id]);

        $program1 = Program::factory()->create([
            'establishment_id' => $this->establishment->id,
            'classe_id' => $class->id,
            'nbr_hours' => 40,
            'nbr_lesson' => 30,
            'nbr_lesson_dig' => 15,
            'nbr_tp' => 10,
            'nbr_tp_dig' => 8,
        ]);

        $program2 = Program::factory()->create([
            'establishment_id' => $this->establishment->id,
            'classe_id' => $class->id,
            'nbr_hours' => 20,
            'nbr_lesson' => 15,
            'nbr_lesson_dig' => 8,
            'nbr_tp' => 5,
            'nbr_tp_dig' => 4,
        ]);

        WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program1->id,
            'recorded_by_user_id' => $this->user->id,
            'nbr_hours_done' => 40,
            'nbr_lesson_done' => 30,
            'nbr_lesson_dig_done' => 15,
            'nbr_tp_done' => 10,
            'nbr_tp_dig_done' => 8,
        ]);

        WeeklyCoverageReport::factory()->create([
            'establishment_id' => $this->establishment->id,
            'program_id' => $program2->id,
            'recorded_by_user_id' => $this->user->id,
            'nbr_hours_done' => 10,
            'nbr_lesson_done' => 10,
            'nbr_lesson_dig_done' => 5,
            'nbr_tp_done' => 3,
            'nbr_tp_dig_done' => 2,
        ]);

        $reportService = new ReportService();
        $classCoverage = $reportService->computeCoverageForClass($class->id);

        $this->assertEquals(2, $classCoverage['programs_count']);
        $this->assertEquals(60, $classCoverage['total_planned']);
        $this->assertEquals(50, $classCoverage['total_done']);
    }
}
