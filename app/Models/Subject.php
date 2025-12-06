<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'establishment_id',
        'department_id',
        'name',
        'code',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the establishment that owns this subject
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the department that owns this subject
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Scope to filter by establishment ID
     */
    public function scopeForEstablishment($query, $establishmentId)
    {
        return $query->where('establishment_id', $establishmentId);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
