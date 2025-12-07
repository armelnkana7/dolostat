<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'establishment_id',
        'name',
        'level',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the establishment that owns this class
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get all programs for this class
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'classe_id');
    }

    /**
     * Get all weekly coverage reports for programs in this class
     */
    public function weeklyReports(): HasManyThrough
    {
        return $this->hasManyThrough(
            WeeklyCoverageReport::class,
            Program::class,
            'classe_id',
            'program_id'
        )->select('weekly_coverage_reports.*')
            ->withoutGlobalScope(\App\Models\Scopes\AcademicYearScope::class)
            ->where('weekly_coverage_reports.establishment_id', $this->establishment_id);
    }

    /**
     * Scope to filter by establishment ID
     */
    public function scopeForEstablishment($query, $establishmentId)
    {
        return $query->where('establishment_id', $establishmentId);
    }
}
