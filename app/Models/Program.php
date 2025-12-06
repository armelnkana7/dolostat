<?php

namespace App\Models;

use App\Models\Scopes\EstablishmentScope;
use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    protected $table = 'programs';

    protected $fillable = [
        'establishment_id',
        'classe_id',
        'subject_id',
        'academic_year_id',
        'hours_per_week',
        'description',
        'nbr_hours',
        'nbr_lesson',
        'nbr_lesson_dig',
        'nbr_tp',
        'nbr_tp_dig',
        'notes',
    ];

    protected $casts = [
        'hours_per_week' => 'integer',
        'nbr_hours' => 'integer',
        'nbr_lesson' => 'integer',
        'nbr_lesson_dig' => 'integer',
        'nbr_tp' => 'integer',
        'nbr_tp_dig' => 'integer',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EstablishmentScope());
        static::addGlobalScope(new AcademicYearScope());
    }

    /**
     * Get the establishment that owns this program
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the school class for this program
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'classe_id');
    }

    /**
     * Get the subject for this program
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the academic year for this program
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get weekly coverage reports for this program
     */
    public function weeklyCoverageReports()
    {
        return $this->hasMany(WeeklyCoverageReport::class);
    }

    /**
     * Scope to filter by establishment ID
     */
    public function scopeForEstablishment($query, $establishmentId)
    {
        return $query->where('establishment_id', $establishmentId);
    }
}
