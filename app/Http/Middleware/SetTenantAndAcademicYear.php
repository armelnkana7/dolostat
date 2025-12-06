<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SetTenantAndAcademicYear Middleware
 * 
 * Ensures that the current establishment and academic year are set in the session
 * for each authenticated request.
 */
class SetTenantAndAcademicYear
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            // Set default establishment if not in session
            if (!session()->has('establishment_id')) {
                session(['establishment_id' => $request->user()->establishment_id]);
            }

            // Set default academic year if not in session (and establishment is set)
            if (!session()->has('academic_year_id') && session('establishment_id')) {
                $establishmentId = session('establishment_id');
                $activeYear = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
                    ->where('is_active', true)
                    ->first();

                if ($activeYear) {
                    session(['academic_year_id' => $activeYear->id]);
                }
            }
        }

        return $next($request);
    }
}
