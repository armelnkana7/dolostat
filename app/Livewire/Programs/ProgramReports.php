<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use Livewire\Component;
use App\Models\AcademicYear;
use App\Helpers\AcademicYearHelper;
use App\Livewire\Traits\WithToasts;
use App\Models\WeeklyCoverageReport;

/**
 * Program Reports Component
 * 
 * Affiche les programmes avec leurs rapports hebdomadaires
 * Permet de consulter, enregistrer et supprimer les rapports
 */
class ProgramReports extends Component
{
    use WithToasts;

    public $programs = [];
    public $selectedProgramId = null;
    public $weeklyReports = [];
    public $academicYear;

    public function mount()
    {
        $this->academicYear = AcademicYear::find(
            AcademicYearHelper::getCurrentAcademicYearId()
        );
        $this->loadPrograms();
    }

    public function loadPrograms()
    {
        $userRole = auth()->user()->roles->first()?->name;

        // Si c'est un pédagogue, charger ses départements
        if ($userRole === 'pedagogical_animator') {
            // Charger les programmes des classes du département de l'utilisateur
            $this->programs = Program::whereHas('schoolClass', function ($query) {
                $query->where('department_id', auth()->user()->department_id);
            })->with(['schoolClass', 'subject', 'subject.department'])->get();
        } else {
            // Pour l'admin et le censeur, charger tous les programmes de l'établissement
            $this->programs = Program::where('establishment_id', auth()->user()->establishment_id)
                ->with(['schoolClass', 'subject', 'subject.department'])
                ->get();
        }
    }

    public function selectProgram($programId)
    {
        $this->selectedProgramId = $programId;
        $this->loadWeeklyReports();
    }

    public function loadWeeklyReports()
    {
        if (!$this->selectedProgramId) {
            $this->weeklyReports = [];
            return;
        }

        $this->weeklyReports = WeeklyCoverageReport::where('program_id', $this->selectedProgramId)
            ->where('academic_year_id', $this->academicYear->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function deleteReport($reportId)
    {
        try {
            WeeklyCoverageReport::destroy($reportId);
            $this->toastSuccess('Rapport supprimé avec succès', 'Suppression');
            $this->loadWeeklyReports();
        } catch (\Exception $e) {
            $this->toastError($e->getMessage(), 'Erreur');
        }
    }

    public function deleteProgram($programId)
    {
        try {
            // Supprimer aussi les rapports associés
            WeeklyCoverageReport::where('program_id', $programId)->delete();
            Program::destroy($programId);

            $this->toastSuccess('Programme et ses rapports supprimés', 'Suppression');
            $this->selectedProgramId = null;
            $this->loadPrograms();
        } catch (\Exception $e) {
            $this->toastError($e->getMessage(), 'Erreur');
        }
    }

    public function render()
    {
        return view('livewire.programs.program-reports', [
            'selectedProgram' => $this->selectedProgramId ? Program::find($this->selectedProgramId) : null,
        ]);
    }
}
