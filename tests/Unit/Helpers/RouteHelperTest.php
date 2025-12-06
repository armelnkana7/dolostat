<?php

namespace Tests\Unit\Helpers;

use App\Helpers\RouteHelper;
use App\Models\SchoolClass;
use Tests\TestCase;

class RouteHelperTest extends TestCase
{
    /** @test */
    public function it_generates_dashboard_route()
    {
        $route = RouteHelper::dashboard();
        $this->assertEquals(route('dashboard'), $route);
    }

    /** @test */
    public function it_generates_establishments_routes()
    {
        $this->assertEquals(route('establishments.index'), RouteHelper::establishmentsIndex());
        $this->assertEquals(route('establishments.create'), RouteHelper::establishmentCreate());
    }

    /** @test */
    public function it_generates_class_routes()
    {
        $class = SchoolClass::factory()->create();

        $this->assertEquals(route('classes.index'), RouteHelper::classesIndex());
        $this->assertEquals(route('classes.create'), RouteHelper::classCreate());
        $this->assertEquals(route('classes.show', $class->id), RouteHelper::classShow($class));
        $this->assertEquals(route('classes.edit', $class->id), RouteHelper::classEdit($class->id));
    }

    /** @test */
    public function it_generates_academic_year_routes()
    {
        $this->assertEquals(route('academic-years.index'), RouteHelper::academicYearsIndex());
        $this->assertEquals(route('academic-years.create'), RouteHelper::academicYearCreate());
    }

    /** @test */
    public function it_generates_department_routes()
    {
        $this->assertEquals(route('departments.index'), RouteHelper::departmentsIndex());
        $this->assertEquals(route('departments.create'), RouteHelper::departmentCreate());
    }

    /** @test */
    public function it_generates_subject_routes()
    {
        $this->assertEquals(route('subjects.index'), RouteHelper::subjectsIndex());
        $this->assertEquals(route('subjects.create'), RouteHelper::subjectCreate());
    }

    /** @test */
    public function it_generates_program_routes()
    {
        $this->assertEquals(route('programs.index'), RouteHelper::programsIndex());
        $this->assertEquals(route('programs.create'), RouteHelper::programCreate());
    }

    /** @test */
    public function it_generates_user_routes()
    {
        $this->assertEquals(route('users.index'), RouteHelper::usersIndex());
        $this->assertEquals(route('users.create'), RouteHelper::userCreate());
    }

    /** @test */
    public function it_generates_coverage_routes()
    {
        $this->assertEquals(route('weekly-coverage.create'), RouteHelper::coverageCreate());
    }
}
