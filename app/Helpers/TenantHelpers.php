<?php

/**
 * Get the current establishment ID from session or user
 *
 * @return int|null
 */
function currentEstablishmentId(): ?int
{
    return session('establishment_id') ?? auth()->user()?->establishment_id;
}

/**
 * Get the current establishment model
 *
 * @return \App\Models\Establishment|null
 */
function currentEstablishment()
{
    $id = currentEstablishmentId();
    return $id ? \App\Models\Establishment::find($id) : null;
}

/**
 * Get the current academic year ID from session
 *
 * @return int|null
 */
function currentAcademicYearId(): ?int
{
    return session('academic_year_id');
}

/**
 * Get the current academic year model
 *
 * @return \App\Models\AcademicYear|null
 */
function currentAcademicYear()
{
    $id = currentAcademicYearId();
    return $id ? \App\Models\AcademicYear::find($id) : null;
}
