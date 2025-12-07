<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\Establishment;

class AcademicYearHelper
{
    /**
     * Récupère l'année académique en cours
     * Priorité: session('academic_year_id') > is_active = true > par date courante
     * 
     * @param int|null $establishmentId
     * @return AcademicYear|null
     */
    public static function getCurrentAcademicYear($establishmentId = null): ?AcademicYear
    {
        // 1. Vérifier la session d'abord (établissement actuel)
        if (session('academic_year_id')) {
            $year = AcademicYear::find(session('academic_year_id'));
            if ($year) {
                return $year;
            }
        }

        // 2. Si pas d'établissement fourni, vérifier si un utilisateur est authentifié
        if (!$establishmentId && auth()->check()) {
            $establishmentId = auth()->user()->establishment_id;
        }

        // 3. Si toujours pas d'établissement, retourner null (cas du seeding)
        if (!$establishmentId) {
            return null;
        }

        // 4. Chercher une année active
        $activeYear = AcademicYear::query()
            ->forEstablishment($establishmentId)
            ->active()
            ->first();

        if ($activeYear) {
            return $activeYear;
        }

        $establishment = Establishment::find($establishmentId);
        if (!$establishment) {
            return null;
        }

        // 5. Chercher par date courante (start_date <= aujourd'hui <= end_date)
        $today = Carbon::today();
        $currentYear = AcademicYear::findOrFail($establishment->academic_year_id);

        return $currentYear;
    }

    /**
     * Récupère l'ID de l'année académique en cours
     * 
     * @param int|null $establishmentId
     * @return int|null
     */
    public static function getCurrentAcademicYearId($establishmentId = null): ?int
    {
        $year = self::getCurrentAcademicYear($establishmentId);
        return $year?->id;
    }

    /**
     * Récupère toutes les années académiques pour un établissement
     * 
     * @param int|null $establishmentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAcademicYearsForEstablishment($establishmentId = null)
    {
        $establishmentId = $establishmentId ?? session('establishment_id');

        return AcademicYear::query()
            ->forEstablishment($establishmentId)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Vérifie si une année est en cours
     * 
     * @param AcademicYear $year
     * @return bool
     */
    public static function isCurrentYear(AcademicYear $year): bool
    {
        return $year->id === self::getCurrentAcademicYearId();
    }

    /**
     * Récupère le label de l'année académique (ex: "2024-2025")
     * 
     * @param AcademicYear $year
     * @return string
     */
    public static function getYearLabel(AcademicYear $year): string
    {
        return $year->title ?? $year->start_date->format('Y') . '-' . $year->end_date->format('Y');
    }
}
