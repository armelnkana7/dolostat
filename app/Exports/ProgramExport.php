<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * ProgramExport
 * 
 * Requires: composer require maatwebsite/excel
 * 
 * Export programs to Excel format.
 */
class ProgramExport implements FromCollection, WithHeadings
{
    public function __construct(private Collection $programs) {}

    public function collection(): Collection
    {
        return $this->programs->map(function ($program) {
            return [
                $program->schoolClass?->name ?? '',
                $program->subject?->name ?? '',
                $program->subject?->code ?? '',
                $program->hours_per_week ?? 0,
                $program->description ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Classe',
            'Matière',
            'Code',
            'Heures/Semaine',
            'Description',
        ];
    }
}
