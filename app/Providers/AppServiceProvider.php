<?php

namespace App\Providers;

use App\Services\EstablishmentService;
use App\Services\AcademicYearService;
use App\Services\DepartmentService;
use App\Services\SchoolClassService;
use App\Services\SubjectService;
use App\Services\ProgramService;
use App\Services\UserService;
use App\Services\ReportService;
use App\Services\WeeklyCoverageReportService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * Bind services into the container for dependency injection
     */
    public function register(): void
    {
        // Register Services in the container
        $this->app->singleton(EstablishmentService::class, function ($app) {
            return new EstablishmentService();
        });

        $this->app->singleton(AcademicYearService::class, function ($app) {
            return new AcademicYearService();
        });

        $this->app->singleton(DepartmentService::class, function ($app) {
            return new DepartmentService();
        });

        $this->app->singleton(SchoolClassService::class, function ($app) {
            return new SchoolClassService();
        });

        $this->app->singleton(SubjectService::class, function ($app) {
            return new SubjectService();
        });

        $this->app->singleton(ProgramService::class, function ($app) {
            return new ProgramService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->singleton(ReportService::class, function ($app) {
            return new ReportService();
        });

        $this->app->singleton(WeeklyCoverageReportService::class, function ($app) {
            return new WeeklyCoverageReportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load tenant helpers
        require_once app_path('Helpers/TenantHelpers.php');
    }
}
