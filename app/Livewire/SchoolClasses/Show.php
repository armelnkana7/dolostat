<?php

namespace App\Livewire\SchoolClasses;

use App\Models\SchoolClass;
use App\Models\WeeklyCoverageReport;
use App\Services\ReportService;
use App\Livewire\Traits\WithConfirmDelete;
use App\Livewire\Traits\WithToasts;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination, WithConfirmDelete, WithToasts;

    public SchoolClass $schoolClass;
    protected ReportService $reportService;

    #[Validate('required|integer|min:1|max:53')]
    public $formData = [];

    public function boot(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function mount($id)
    {
        $this->schoolClass = SchoolClass::findOrFail($id);
        $this->initializeForm();
    }

    public function initializeForm()
    {
        $this->formData = [
            'program_id' => null,
            'nbr_hours_done' => 0,
            'nbr_lesson_done' => 0,
            'nbr_lesson_dig_done' => 0,
            'nbr_tp_done' => 0,
            'nbr_tp_dig_done' => 0,
        ];
    }

    public function addWeeklyReport()
    {
        $this->validate([
            'formData.program_id' => 'required|exists:programs,id',
            'formData.nbr_hours_done' => 'nullable|integer|min:0',
            'formData.nbr_lesson_done' => 'nullable|integer|min:0',
            'formData.nbr_lesson_dig_done' => 'nullable|integer|min:0',
            'formData.nbr_tp_done' => 'nullable|integer|min:0',
            'formData.nbr_tp_dig_done' => 'nullable|integer|min:0',
        ]);

        try {
            WeeklyCoverageReport::create([
                'establishment_id' => $this->schoolClass->establishment_id,
                'program_id' => $this->formData['program_id'],
                'recorded_by_user_id' => auth()->user()->id,
                'nbr_hours_done' => $this->formData['nbr_hours_done'] ?? 0,
                'nbr_lesson_done' => $this->formData['nbr_lesson_done'] ?? 0,
                'nbr_lesson_dig_done' => $this->formData['nbr_lesson_dig_done'] ?? 0,
                'nbr_tp_done' => $this->formData['nbr_tp_done'] ?? 0,
                'nbr_tp_dig_done' => $this->formData['nbr_tp_dig_done'] ?? 0,
            ]);

            $this->toastSuccess('Rapport ajouté avec succès');
            $this->initializeForm();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Erreur lors de l\'ajout du rapport: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $coverage = $this->reportService->computeCoverageForClass($this->schoolClass->id);

        // Récupérer les rapports via la relation HasManyThrough
        $reports = $this->schoolClass->weeklyReports()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.school-classes.show', [
            'coverage' => $coverage,
            'reports' => $reports,
        ]);
    }

    public function generatePdf()
    {
        $this->toastInfo('Génération du PDF en cours...');
        // À implémenter avec laravel-dompdf
    }

    public function generateExcel()
    {
        $this->toastInfo('Génération de l\'Excel en cours...');
        // Implémentation de l'export Excel
    }

    public function delete($id)
    {
        try {
            $report = WeeklyCoverageReport::findOrFail($id);
            $report->delete();
            $this->toastSuccess('Rapport supprimé avec succès');
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
