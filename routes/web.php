<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Livewire\Users\Form as UsersForm;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Programs\Form as ProgramsForm;
use App\Livewire\Programs\Index as ProgramsIndex;
use App\Livewire\Programs\ProgramManager;
use App\Livewire\Subjects\Form as SubjectsForm;
use App\Livewire\Subjects\Index as SubjectsIndex;
use App\Livewire\Departments\Form as DepartmentsForm;
use App\Livewire\WeeklyCoverage\Form as WeeklyCoverageForm;
use App\Livewire\Departments\Index as DepartmentsIndex;
use App\Livewire\AcademicYears\Form as AcademicYearsForm;
use App\Livewire\SchoolClasses\Form as SchoolClassesForm;
use App\Livewire\SchoolClasses\Show as SchoolClassesShow;
use App\Livewire\AcademicYears\Index as AcademicYearsIndex;
use App\Livewire\Establishments\Form as EstablishmentsForm;
use App\Livewire\SchoolClasses\Index as SchoolClassesIndex;
use App\Livewire\Establishments\Index as EstablishmentsIndex;
use App\Livewire\Reports\CoverageReports;
use App\Exports\SchoolClassesExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Protected routes - all require authentication
Route::middleware(['auth'])->group(function () {
    // Establishments
    Route::get('/establishments', EstablishmentsIndex::class)
        ->name('establishments.index');
    Route::get('/establishments/create', EstablishmentsForm::class)
        ->name('establishments.create');
    Route::get('/establishments/{id}/edit', EstablishmentsForm::class)
        ->name('establishments.edit');

    // Academic Years
    Route::get('/academic-years', AcademicYearsIndex::class)
        ->name('academic-years.index');
    Route::get('/academic-years/create', AcademicYearsForm::class)
        ->name('academic-years.create');
    Route::get('/academic-years/{id}/edit', AcademicYearsForm::class)
        ->name('academic-years.edit');

    // Departments
    Route::get('/departments', DepartmentsIndex::class)
        ->name('departments.index');
    Route::get('/departments/create', DepartmentsForm::class)
        ->name('departments.create');
    Route::get('/departments/{id}/edit', DepartmentsForm::class)
        ->name('departments.edit');

    // School Classes
    Route::get('/classes', SchoolClassesIndex::class)
        ->name('classes.index');
    Route::get('/classes/create', SchoolClassesForm::class)
        ->name('classes.create');
    Route::get('/classes/{id}/edit', SchoolClassesForm::class)
        ->name('classes.edit');
    Route::get('/classes/{id}/show', SchoolClassesShow::class)
        ->name('classes.show');

    // Subjects
    Route::get('/subjects', SubjectsIndex::class)
        ->name('subjects.index');
    Route::get('/subjects/create', SubjectsForm::class)
        ->name('subjects.create');
    Route::get('/subjects/{id}/edit', SubjectsForm::class)
        ->name('subjects.edit');

    // Programs
    Route::get('/programs', ProgramsIndex::class)
        ->name('programs.index');
    Route::get('/programs/create', ProgramsForm::class)
        ->name('programs.create');
    Route::get('/programs/{id}/edit', ProgramsForm::class)
        ->name('programs.edit');
    Route::get('/programs/manage', ProgramManager::class)
        ->name('programs.manage')
        ->middleware('can:manage_programs');
    Route::get('/programs/reports', \App\Livewire\Programs\ProgramReports::class)
        ->name('programs.reports');

    // Users
    Route::get('/users', UsersIndex::class)
        ->name('users.index');
    Route::get('/users/create', UsersForm::class)
        ->name('users.create');
    Route::get('/users/{id}/edit', UsersForm::class)
        ->name('users.edit');

    // Weekly Coverage Reports
    Route::get('/weekly-coverage/create', WeeklyCoverageForm::class)
        ->name('weekly-coverage.create');
    Route::get('/weekly-coverage/{id}/edit', WeeklyCoverageForm::class)
        ->name('weekly-coverage.edit');

    // Coverage Reports
    Route::get('/reports/coverage', CoverageReports::class)
        ->name('reports.coverage')
        ->middleware('can:view_reports');

    // Admin - Role & Permissions Management
    Route::get('/admin/role-permissions', \App\Livewire\Admin\RolePermissions::class)
        ->name('admin.role-permissions')
        ->middleware('can:manage_permissions');

    // Reports
    Route::get('/reports/program/{classe}/excel', [ReportController::class, 'exportProgramsExcel'])
        ->name('reports.program.excel');
    Route::get('/reports/program/{classe}/pdf', [ReportController::class, 'exportProgramPdf'])
        ->name('reports.program.pdf');
    Route::get('/reports/weekly-coverage/{program}/pdf', [ReportController::class, 'coveragePdf'])
        ->name('reports.weekly-coverage.pdf');
    Route::get('/reports/weekly-coverage/{program}/excel', [ReportController::class, 'coverageExcel'])
        ->name('reports.weekly-coverage.excel');

    // Export classes to Excel
    Route::get('/export/classes', function () {
        return Excel::download(new SchoolClassesExport, 'classes.xlsx');
    })->name('export.classes');

    // routes/web.php
    Route::get('reports/coverage/pdf', [\App\Http\Controllers\ReportController::class, 'coveragePdf'])
        ->name('reports.coverage.pdf');
    Route::get('reports/coverage/excel', [\App\Http\Controllers\ReportController::class, 'coverageExcel'])
        ->name('reports.coverage.excel');
    Route::get('reports/coverage/csv', [\App\Http\Controllers\ReportController::class, 'coverageCsv'])
        ->name('reports.coverage.csv');

    Route::post('/logout', Logout::class)->name('logout');
});

require __DIR__ . '/auth.php';
