<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;

class CoverageReportViewExport implements FromView, WithEvents, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $exportType; // 'class' ou 'department'

    public function __construct($data, $exportType = 'class')
    {
        $this->data = $data;
        $this->exportType = $exportType;
    }

    public function view(): View
    {
        // Sélectionner la vue appropriée selon le type d'export
        $viewName = match ($this->exportType) {
            'department' => 'exports.coverage-report-by-department',
            'subject' => 'exports.coverage-report-by-subject',
            'global' => 'exports.coverage-report-by-class',
            default => 'exports.coverage-report-by-class',
        };

        return view($viewName, [
            'data' => $this->data,
        ]);
    }

    /**
     * Titre de l'onglet (<= 31 caractères)
     */
    public function title(): string
    {
        return 'Couverture';
    }

    /**
     * Appliquer des styles et dimensions après génération
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Default font
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(9);

                // Header area (first two rows) styling
                // We assume 16 columns (A..P)
                $headerRange = 'A1:P2';

                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF34495E'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Column widths
                $widths = [
                    'A' => 30,
                    'B' => 12,
                    'C' => 12,
                    'D' => 12,
                    'E' => 12,
                    'F' => 12,
                    'G' => 12,
                    'H' => 12,
                    'I' => 12,
                    'J' => 12,
                    'K' => 12,
                    'L' => 12,
                    'M' => 12,
                    'N' => 12,
                    'O' => 12,
                    'P' => 12,
                ];

                foreach ($widths as $col => $w) {
                    $sheet->getColumnDimension($col)->setWidth($w);
                }

                // Row heights for header
                $sheet->getRowDimension(1)->setRowHeight(28);
                $sheet->getRowDimension(2)->setRowHeight(18);

                // Borders for entire used range
                $highestRow = $sheet->getHighestRow();
                $styleRange = 'A1:P' . $highestRow;
                $sheet->getStyle($styleRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFBDC3C7'],
                        ],
                    ],
                ]);

                // Alternate row fill (starting from row 3)
                for ($r = 3; $r <= $highestRow; $r++) {
                    if ($r % 2 == 0) {
                        $sheet->getStyle("A{$r}:P{$r}")->applyFromArray([
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFECF0F1'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
