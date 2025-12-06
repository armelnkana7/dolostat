<?php

namespace App\Livewire\Programs;

use App\Helpers\AcademicYearHelper;
use App\Models\AcademicYear;
use App\Models\Program;
use App\Models\SchoolClass;
use App\Livewire\Traits\WithToasts;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramManager extends Component
{
    use WithPagination, WithToasts;

    public AcademicYear $academicYear;
    public ?SchoolClass $schoolClass = null;
    public $showForm = false;
    public $editingProgram = null;

    // Formulaire
    public $subject_id;
    public $nbr_hours;
    public $nbr_lesson;
    public $nbr_lesson_dig;
    public $nbr_tp;
    public $nbr_tp_dig;
    public $notes;

    public function mount()
    {
        // Récupérer l'année académique en cours
        $this->academicYear = AcademicYear::find(
            AcademicYearHelper::getCurrentAcademicYearId()
        );

        if (!$this->academicYear) {
            $this->toastError('Aucune année académique active');
            return;
        }
    }

    public function selectClass(SchoolClass $class)
    {
        $this->schoolClass = $class;
        $this->resetPage();
    }

    public function addProgram()
    {
        $this->validate([
            'subject_id' => 'required|exists:subjects,id',
            'nbr_hours' => 'required|integer|min:0',
            'nbr_lesson' => 'required|integer|min:0',
            'nbr_lesson_dig' => 'required|integer|min:0',
            'nbr_tp' => 'required|integer|min:0',
            'nbr_tp_dig' => 'required|integer|min:0',
        ]);

        try {
            Program::create([
                'subject_id' => $this->subject_id,
                'classe_id' => $this->schoolClass->id,
                'establishment_id' => session('establishment_id'),
                'academic_year_id' => $this->academicYear->id,
                'nbr_hours' => $this->nbr_hours,
                'nbr_lesson' => $this->nbr_lesson,
                'nbr_lesson_dig' => $this->nbr_lesson_dig,
                'nbr_tp' => $this->nbr_tp,
                'nbr_tp_dig' => $this->nbr_tp_dig,
            'establishment_id' => auth()->user()->establishment_id,
            ]);

            $this->toastSuccess('Programme ajouté avec succès');
            $this->resetForm();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Erreur: ' . $e->getMessage());
        }
    }

    public function editProgram(Program $program)
    {
        $this->editingProgram = $program;
        $this->subject_id = $program->subject_id;
        $this->nbr_hours = $program->nbr_hours;
        $this->nbr_lesson = $program->nbr_lesson;
        $this->nbr_lesson_dig = $program->nbr_lesson_dig;
        $this->nbr_tp = $program->nbr_tp;
        $this->nbr_tp_dig = $program->nbr_tp_dig;
        $this->notes = $program->notes;
        $this->showForm = true;
    }

    public function updateProgram()
    {
        $this->validate([
            'subject_id' => 'required|exists:subjects,id',
            'nbr_hours' => 'required|integer|min:0',
            'nbr_lesson' => 'required|integer|min:0',
            'nbr_lesson_dig' => 'required|integer|min:0',
            'nbr_tp' => 'required|integer|min:0',
            'nbr_tp_dig' => 'required|integer|min:0',
        ]);

        try {
            $this->editingProgram->update([
                'subject_id' => $this->subject_id,
                'nbr_hours' => $this->nbr_hours,
                'nbr_lesson' => $this->nbr_lesson,
                'nbr_lesson_dig' => $this->nbr_lesson_dig,
                'nbr_tp' => $this->nbr_tp,
                'nbr_tp_dig' => $this->nbr_tp_dig,
                'establishment_id' => auth()->user()->establishment_id,
            ]);

            $this->toastSuccess('Programme mis à jour avec succès');
            $this->resetForm();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Erreur: ' . $e->getMessage());
        }
    }

    public function deleteProgram(Program $program)
    {
        try {
            $program->delete();
            $this->toastSuccess('Programme supprimé avec succès');
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Erreur: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->showForm = false;
        $this->editingProgram = null;
        $this->subject_id = null;
        $this->nbr_hours = 0;
        $this->nbr_lesson = 0;
        $this->nbr_lesson_dig = 0;
        $this->nbr_tp = 0;
        $this->nbr_tp_dig = 0;
        $this->notes = null;
    }

    public function render()
    {
        // Déterminer quelles classes afficher selon le rôle
        $query = SchoolClass::query();

        // Animateur pédagogique: ses classes seulement
        if (auth()->user()->hasRole('pedagogical_animator')) {
            $query->whereHas('programs', function ($q) {
                $q->where('establishment_id', auth()->user()->establishment_id);
            });
        }
        // Censeur: toutes les classes de l'établissement
        elseif (auth()->user()->hasRole('censor')) {
            $query->whereHas('establishment', function ($q) {
                $q->where('id', auth()->user()->establishment_id);
            });
        }

        $classes = $query
            ->where('establishment_id', auth()->user()->establishment_id)
            ->get();

        $programs = [];
        if ($this->schoolClass) {
            $programs = $this->schoolClass->programs()
                ->where('academic_year_id', $this->academicYear->id)
                ->paginate(10);
        }

        // dd($classes);

        return view('livewire.programs.program-manager', [
            'classes' => $classes,
            'programs' => $programs,
            'subjects' => \App\Models\Subject::all(),
        ]);
    }
}
