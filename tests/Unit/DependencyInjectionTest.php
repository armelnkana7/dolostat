<?php

namespace Tests\Unit;

use App\Services\EstablishmentService;
use App\Services\AcademicYearService;
use App\Services\DepartmentService;
use App\Services\SchoolClassService;
use App\Services\SubjectService;
use App\Services\ProgramService;
use App\Services\UserService;
use App\Services\ReportService;
use App\Services\WeeklyCoverageReportService;
use Tests\TestCase;

class DependencyInjectionTest extends TestCase
{
    /**
     * Test that all services are properly bound in the container
     */
    public function test_establishment_service_is_bound()
    {
        $service = $this->app->make(EstablishmentService::class);
        $this->assertInstanceOf(EstablishmentService::class, $service);
    }

    public function test_academic_year_service_is_bound()
    {
        $service = $this->app->make(AcademicYearService::class);
        $this->assertInstanceOf(AcademicYearService::class, $service);
    }

    public function test_department_service_is_bound()
    {
        $service = $this->app->make(DepartmentService::class);
        $this->assertInstanceOf(DepartmentService::class, $service);
    }

    public function test_school_class_service_is_bound()
    {
        $service = $this->app->make(SchoolClassService::class);
        $this->assertInstanceOf(SchoolClassService::class, $service);
    }

    public function test_subject_service_is_bound()
    {
        $service = $this->app->make(SubjectService::class);
        $this->assertInstanceOf(SubjectService::class, $service);
    }

    public function test_program_service_is_bound()
    {
        $service = $this->app->make(ProgramService::class);
        $this->assertInstanceOf(ProgramService::class, $service);
    }

    public function test_user_service_is_bound()
    {
        $service = $this->app->make(UserService::class);
        $this->assertInstanceOf(UserService::class, $service);
    }

    public function test_report_service_is_bound()
    {
        $service = $this->app->make(ReportService::class);
        $this->assertInstanceOf(ReportService::class, $service);
    }

    public function test_weekly_coverage_report_service_is_bound()
    {
        $service = $this->app->make(WeeklyCoverageReportService::class);
        $this->assertInstanceOf(WeeklyCoverageReportService::class, $service);
    }

    /**
     * Test that services are singletons
     */
    public function test_services_are_singletons()
    {
        $service1 = $this->app->make(EstablishmentService::class);
        $service2 = $this->app->make(EstablishmentService::class);

        $this->assertSame($service1, $service2);
    }

    /**
     * Test that services can be auto-wired in controller/livewire
     */
    public function test_service_can_be_injected_via_constructor()
    {
        // Simulate dependency injection via parameter binding
        $callable = function (EstablishmentService $service) {
            return $service;
        };

        $service = $this->app->call($callable);
        $this->assertInstanceOf(EstablishmentService::class, $service);
    }
}
