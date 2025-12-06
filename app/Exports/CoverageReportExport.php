<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CoverageReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $filterType;
    protected $title;

    public function __construct($data, $filterType, $title)
    {
        $this->data = $data;
        $this->filterType = $filterType;
        $this->title = $title;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                'name' => $item['name'] ?? '',
                'elements' => $item['programs_count'] ?? 0,

                // COUVERTURE DES HEURES
                'heures_prevues' => $item['total_planned']['hours'] ?? 0,
                'heures_faites' => $item['total_done']['hours'] ?? 0,
                'heures_couv_%' => $item['total_planned']['hours'] > 0 ? number_format(($item['total_done']['hours'] / $item['total_planned']['hours'] * 100), 2) : 0,

                // COUVERTURE DES LEÇONS
                'lecons_prevues' => $item['total_planned']['lesson'] ?? 0,
                'lecons_faites' => $item['total_done']['lesson'] ?? 0,
                'lecons_couv_%' => $item['total_planned']['lesson'] > 0 ? number_format(($item['total_done']['lesson'] / $item['total_planned']['lesson'] * 100), 2) : 0,

                // LEÇONS DIGITALISÉES
                'lecons_dig_prevues' => $item['total_planned']['lesson_dig'] ?? 0,
                'lecons_dig_faites' => $item['total_done']['lesson_dig'] ?? 0,
                'lecons_dig_couv_%' => $item['total_planned']['lesson_dig'] > 0 ? number_format(($item['total_done']['lesson_dig'] / $item['total_planned']['lesson_dig'] * 100), 2) : 0,

                // TP
                'tp_prevus' => $item['total_planned']['tp'] ?? 0,
                'tp_realises' => $item['total_done']['tp'] ?? 0,
                'tp_couv_%' => $item['total_planned']['tp'] > 0 ? number_format(($item['total_done']['tp'] / $item['total_planned']['tp'] * 100), 2) : 0,

                // TP DIGITALISÉS
                'tp_dig_prevus' => $item['total_planned']['tp_dig'] ?? 0,
                'tp_dig_realises' => $item['total_done']['tp_dig'] ?? 0,
                'tp_dig_couv_%' => $item['total_planned']['tp_dig'] > 0 ? number_format(($item['total_done']['tp_dig'] / $item['total_planned']['tp_dig'] * 100), 2) : 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Classes/NIV',
            'Éléments',

            // COUVERTURE DES HEURES
            'Heures Prévues',
            'Heures Faites',
            'Heures Couverture %',

            // COUVERTURE DES LEÇONS
            'Leçons Prévues',
            'Leçons Faites',
            'Leçons Couverture %',

            // LEÇONS DIGITALISÉES
            'Leçons Dig. Prévues',
            'Leçons Dig. Faites',
            'Leçons Dig. Couverture %',

            // TP
            'TP Prévus',
            'TP Réalisés',
            'TP Couverture %',

            // TP DIGITALISÉS
            'TP Dig. Prévus',
            'TP Dig. Réalisés',
            'TP Dig. Couverture %',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4472C4']], 'font' => ['color' => ['argb' => 'FFFFFFFF']]],
        ];
    }
}
