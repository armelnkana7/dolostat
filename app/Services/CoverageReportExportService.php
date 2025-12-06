<?php

namespace App\Services;

use App\Exports\CoverageReportExport;
use App\Exports\CoverageReportViewExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CoverageReportExportService
{
    /**
     * Exporte les rapports en CSV
     */
    public function exportToCsv($data, $exportType = 'class')
    {
        $filename = "rapport-couverture-" . $exportType . "-" . Carbon::now()->format('Y-m-d-His') . ".csv";

        // Prepare CSV header
        $header = ['Nom', 'Éléments', 'Heures Planifiées', 'Heures Réalisées', 'Cours Planifiés', 'Cours Réalisés', 'TP Planifiés', 'TP Réalisés', 'Couverture %'];

        return response()->streamDownload(
            function () use ($data, $header) {
                $handle = fopen('php://output', 'w');

                // Add BOM for Excel UTF-8 compatibility
                fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // Write headers
                fputcsv($handle, $header, ',', '"');

                // Write data
                foreach ($data as $item) {
                    fputcsv($handle, [
                        $item->name ?? '',
                        $item->subjects_count ?? $item->programs_count ?? 0,
                        $item->total_planned['hours'] ?? 0,
                        $item->total_done['hours'] ?? 0,
                        $item->total_planned['lesson'] ?? 0,
                        $item->total_done['lesson'] ?? 0,
                        $item->total_planned['tp'] ?? 0,
                        $item->total_done['tp'] ?? 0,
                        number_format($item->coverage_percentage ?? 0, 2),
                    ], ',', '"');
                }

                fclose($handle);
            },
            $filename,
            ['Content-Type' => 'text/csv; charset=utf-8']
        );
    }

    /**
     * Exporte les rapports en Excel
     * $exportType : 'class' ou 'department'
     */
    public function exportToExcel($data, $exportType = 'class')
    {
        $filename = "rapport-couverture-" . $exportType . "-" . Carbon::now()->format('Y-m-d-His') . ".xlsx";

        return Excel::download(
            new CoverageReportViewExport($data, $exportType),
            $filename
        );
    }

    /**
     * Exporte les rapports en PDF
     * $exportType : 'class' ou 'department'
     */
    public function exportToPdf($data, $exportType = 'class')
    {
        $filename = "rapport-couverture-" . $exportType . "-" . Carbon::now()->format('Y-m-d-His') . ".pdf";

        try {
            // Sélectionner la vue appropriée selon le type d'export
            $viewName = $exportType === 'department'
                ? 'exports.coverage-report-pdf-department'
                : 'exports.coverage-report-pdf-class';

            $html = view($viewName, [
                'data' => $data,
            ])->render();

            // Clean UTF-8 characters before PDF generation
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

            // Additional sanitization: remove problematic characters while preserving accents
            $html = iconv('UTF-8', 'UTF-8//IGNORE', $html);

            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'landscape')
                ->setOption('encoding', 'UTF-8')
                ->setOption('enable-local-file-access', true);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log the error and return error response
            Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }
}
