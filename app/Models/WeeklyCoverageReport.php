<?php

namespace App\Models;

use App\Models\Scopes\EstablishmentScope;
use App\Models\Scopes\AcademicYearScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyCoverageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'program_id',
        'recorded_by_user_id',
        'academic_year_id',
        'nbr_hours_done',
        'nbr_lesson_done',
        'nbr_lesson_dig_done',
        'nbr_tp_done',
        'nbr_tp_dig_done',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EstablishmentScope());
        static::addGlobalScope(new AcademicYearScope());
    }

    /**
     * Relations
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Scopes
     */
    public function scopeByEstablishment($query, $establishmentId = null)
    {
        return $query->where('establishment_id', $establishmentId ?? session('establishment_id'));
    }

    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }
}
