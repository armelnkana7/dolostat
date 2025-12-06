<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicYear extends Model
{
    protected $table = 'academic_years';

    protected $fillable = [
        'establishment_id',
        'title',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Get the establishment that owns this academic year
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Scope to filter by establishment ID
     */
    public function scopeForEstablishment($query, $establishmentId)
    {
        return $query->where('establishment_id', $establishmentId);
    }

    /**
     * Scope to get only active academic years
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
