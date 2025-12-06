<?php

namespace App\Helpers;

/**
 * Route Navigation Helpers
 * Simplified route generation with proper fallbacks
 */
class RouteHelper
{
    /**
     * Get establishments index route
     */
    public static function establishmentsIndex(): string
    {
        return route('establishments.index');
    }

    /**
     * Get establishment create route
     */
    public static function establishmentCreate(): string
    {
        return route('establishments.create');
    }

    /**
     * Get establishment edit route
     */
    public static function establishmentEdit($establishment): string
    {
        $id = is_object($establishment) ? $establishment->id : $establishment;
        return route('establishments.edit', $id);
    }

    /**
     * Get academic years index route
     */
    public static function academicYearsIndex(): string
    {
        return route('academic-years.index');
    }

    /**
     * Get academic year create route
     */
    public static function academicYearCreate(): string
    {
        return route('academic-years.create');
    }

    /**
     * Get academic year edit route
     */
    public static function academicYearEdit($year): string
    {
        $id = is_object($year) ? $year->id : $year;
        return route('academic-years.edit', $id);
    }

    /**
     * Get departments index route
     */
    public static function departmentsIndex(): string
    {
        return route('departments.index');
    }

    /**
     * Get department create route
     */
    public static function departmentCreate(): string
    {
        return route('departments.create');
    }

    /**
     * Get department edit route
     */
    public static function departmentEdit($department): string
    {
        $id = is_object($department) ? $department->id : $department;
        return route('departments.edit', $id);
    }

    /**
     * Get school classes index route
     */
    public static function classesIndex(): string
    {
        return route('classes.index');
    }

    /**
     * Get school class create route
     */
    public static function classCreate(): string
    {
        return route('classes.create');
    }

    /**
     * Get school class show route
     */
    public static function classShow($class): string
    {
        $id = is_object($class) ? $class->id : $class;
        return route('classes.show', $id);
    }

    /**
     * Get school class edit route
     */
    public static function classEdit($class): string
    {
        $id = is_object($class) ? $class->id : $class;
        return route('classes.edit', $id);
    }

    /**
     * Get subjects index route
     */
    public static function subjectsIndex(): string
    {
        return route('subjects.index');
    }

    /**
     * Get subject create route
     */
    public static function subjectCreate(): string
    {
        return route('subjects.create');
    }

    /**
     * Get subject edit route
     */
    public static function subjectEdit($subject): string
    {
        $id = is_object($subject) ? $subject->id : $subject;
        return route('subjects.edit', $id);
    }

    /**
     * Get programs index route
     */
    public static function programsIndex(): string
    {
        return route('programs.index');
    }

    /**
     * Get program create route
     */
    public static function programCreate(): string
    {
        return route('programs.create');
    }

    /**
     * Get program edit route
     */
    public static function programEdit($program): string
    {
        $id = is_object($program) ? $program->id : $program;
        return route('programs.edit', $id);
    }

    /**
     * Get users index route
     */
    public static function usersIndex(): string
    {
        return route('users.index');
    }

    /**
     * Get user create route
     */
    public static function userCreate(): string
    {
        return route('users.create');
    }

    /**
     * Get user edit route
     */
    public static function userEdit($user): string
    {
        $id = is_object($user) ? $user->id : $user;
        return route('users.edit', $id);
    }

    /**
     * Get weekly coverage create route
     */
    public static function coverageCreate(): string
    {
        return route('weekly-coverage.create');
    }

    /**
     * Get coverage report edit route
     */
    public static function coverageEdit($report): string
    {
        $id = is_object($report) ? $report->id : $report;
        return route('coverage.edit', $id);
    }

    /**
     * Get dashboard route
     */
    public static function dashboard(): string
    {
        return route('dashboard');
    }
}
