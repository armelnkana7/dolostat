<?php

namespace App\Livewire\Subjects;

use Livewire\Component;
use App\Services\SubjectService;
use App\Livewire\Traits\WithToasts;
use App\Models\Department;

/**
 * Subjects Form Component
 */
class Form extends Component
{
    use WithToasts;
    public $subjectId = null;
    public $establishment_id = null;
    public $department_id = null;
    public $name = '';
    public $code = '';
    public $description = '';
    public $returnUrl = null;

    protected function rules()
    {
        return [
            'establishment_id' => 'required|exists:establishments,id',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ];
    }

    public function mount(SubjectService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('subjects.index');

        if ($id) {
            $subject = $service->find($id);
            if ($subject) {
                $this->subjectId = $subject->id;
                $this->establishment_id = $subject->establishment_id;
                $this->department_id = $subject->department_id;
                $this->name = $subject->name;
                $this->code = $subject->code;
                $this->description = $subject->description;
            }
        }
    }

    public function save(SubjectService $service)
    {
        $this->validate();

        if ($this->subjectId) {
            $service->update($this->subjectId, [
                'establishment_id' => $this->establishment_id,
                'department_id' => $this->department_id,
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
            ]);
            $this->toastSuccess('Matière mise à jour avec succès');
        } else {
            $service->create([
                'establishment_id' => $this->establishment_id,
                'department_id' => $this->department_id,
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
            ]);
            $this->toastSuccess('Matière créée avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        $departments = Department::where('establishment_id', $this->establishment_id)->get();
        return view('livewire.subjects.form', compact('departments'));
    }
}
