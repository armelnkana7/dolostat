<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Establishment extends Model
{
    use HasFactory;
    protected $table = 'establishments';

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'meta',
        'academic_year_id',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get all academic years for this establishment
     */
    public function academicYears(): HasMany
    {
        return $this->hasMany(AcademicYear::class);
    }

    /**
     * Get all school classes for this establishment
     */
    public function schoolClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    /**
     * Get all departments for this establishment
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all subjects for this establishment
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get all programs for this establishment
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Get all users for this establishment
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the current academic year for this establishment
     */
    public function currentAcademicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    /**
     * Scope to filter by establishment ID
     */
    public function scopeForEstablishment($query, $establishmentId)
    {
        return $query->where('id', $establishmentId);
    }
}
