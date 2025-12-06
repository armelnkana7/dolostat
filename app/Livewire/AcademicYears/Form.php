<?php

namespace App\Livewire\AcademicYears;

use App\Models\Establishment;
use App\Services\AcademicYearService;
use Livewire\Component;

/**
 * AcademicYears Form Component
 */
class Form extends Component
{
    public $academicYearId = null;
    public $establishment_id = null;
    public $title = '';
    public $start_date = '';
    public $end_date = '';
    public $is_active = false;
    public $returnUrl = null;

    protected function rules()
    {
        return [
            'establishment_id' => 'required|exists:establishments,id',
            'title' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ];
    }

    public function mount(AcademicYearService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('academic-years.index');

        if ($id) {
            $academicYear = $service->find($id);
            if ($academicYear) {
                $this->academicYearId = $academicYear->id;
                $this->establishment_id = $academicYear->establishment_id;
                $this->title = $academicYear->title;
                $this->start_date = $academicYear->start_date?->format('Y-m-d');
                $this->end_date = $academicYear->end_date?->format('Y-m-d');
                $this->is_active = $academicYear->is_active;
            }
        }
    }

    public function save(AcademicYearService $service)
    {
        $this->validate();

        if ($this->academicYearId) {
            $service->update($this->academicYearId, [
                'establishment_id' => $this->establishment_id,
                'title' => $this->title,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
            ]);
            $this->dispatch('notify', message: 'Année académique mise à jour avec succès');
        } else {
            $service->create([
                'establishment_id' => $this->establishment_id,
                'title' => $this->title,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active,
            ]);
            $this->dispatch('notify', message: 'Année académique créée avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        $establishments = Establishment::all();
        return view('livewire.academic-years.form', compact('establishments'));
    }
}
