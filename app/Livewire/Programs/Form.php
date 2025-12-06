<?php

namespace App\Livewire\Programs;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Services\ProgramService;
use Livewire\Component;

/**
 * Programs Form Component
 */
class Form extends Component
{
    public $programId = null;
    public $establishment_id = null;
    public $classe_id = null;
    public $subject_id = null;
    public $nbr_hours = '';
    public $nbr_lesson = '';
    public $nbr_lesson_dig = '';
    public $nbr_tp = '';
    public $nbr_tp_dig = '';
    public $description = '';
    public $returnUrl = null;

    protected function rules()
    {
        $rules = [
            'establishment_id' => 'required|exists:establishments,id',
            'classe_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'nbr_hours' => 'nullable|integer|min:0',
            'nbr_lesson' => 'nullable|integer|min:0',
            'nbr_lesson_dig' => 'nullable|integer|min:0',
            'nbr_tp' => 'nullable|integer|min:0',
            'nbr_tp_dig' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ];

        // Ajouter une validation unique pour éviter les doublons
        // La contrainte unique porte sur (establishment_id, classe_id, subject_id, academic_year_id)
        $academicYearId = session('academic_year_id') ?? \App\Helpers\AcademicYearHelper::getCurrent()->id;

        $uniqueRule = \Illuminate\Validation\Rule::unique('programs')
            ->where('establishment_id', $this->establishment_id)
            ->where('classe_id', $this->classe_id)
            ->where('subject_id', $this->subject_id)
            ->where('academic_year_id', $academicYearId);

        // Si on est en édition, exclure le programme actuel de la vérification d'unicité
        if ($this->programId) {
            $uniqueRule->ignore($this->programId);
        }

        return $rules;
    }

    public function mount(ProgramService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('programs.index');

        if ($id) {
            $program = $service->find($id, ['schoolClass', 'subject']);
            if ($program) {
                $this->programId = $program->id;
                $this->establishment_id = $program->establishment_id;
                $this->classe_id = $program->classe_id;
                $this->subject_id = $program->subject_id;
                $this->nbr_hours = $program->nbr_hours;
                $this->nbr_lesson = $program->nbr_lesson;
                $this->nbr_lesson_dig = $program->nbr_lesson_dig;
                $this->nbr_tp = $program->nbr_tp;
                $this->nbr_tp_dig = $program->nbr_tp_dig;
                $this->description = $program->description;
            }
        }
    }

    public function save(ProgramService $service)
    {
        $this->validate();

        if ($this->programId) {
            $service->update($this->programId, [
                'establishment_id' => $this->establishment_id,
                'classe_id' => $this->classe_id,
                'subject_id' => $this->subject_id,
                'nbr_hours' => $this->nbr_hours,
                'nbr_lesson' => $this->nbr_lesson,
                'nbr_lesson_dig' => $this->nbr_lesson_dig,
                'nbr_tp' => $this->nbr_tp,
                'nbr_tp_dig' => $this->nbr_tp_dig,
                'description' => $this->description,
            ]);
            $this->dispatch('notify', message: 'Programme mis à jour avec succès');
        } else {
            $service->create([
                'establishment_id' => $this->establishment_id,
                'classe_id' => $this->classe_id,
                'subject_id' => $this->subject_id,
                'nbr_hours' => $this->nbr_hours,
                'nbr_lesson' => $this->nbr_lesson,
                'nbr_lesson_dig' => $this->nbr_lesson_dig,
                'nbr_tp' => $this->nbr_tp,
                'nbr_tp_dig' => $this->nbr_tp_dig,
                'description' => $this->description,
            ]);
            $this->dispatch('notify', message: 'Programme créé avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        $classes = SchoolClass::where('establishment_id', $this->establishment_id)->get();
        $subjects = Subject::where('establishment_id', $this->establishment_id)
            ->with('department')
            ->get();

        return view('livewire.programs.form', compact('classes', 'subjects'));
    }
}
