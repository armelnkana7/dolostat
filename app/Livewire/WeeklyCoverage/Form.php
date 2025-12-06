<?php

namespace App\Livewire\WeeklyCoverage;

use App\Models\Program;
use App\Models\WeeklyCoverageReport;
use Livewire\Component;
use App\Services\ProgramService;
use App\Services\WeeklyCoverageReportService;
use App\Livewire\Traits\WithToasts;
use App\Helpers\AcademicYearHelper;

class Form extends Component
{
    use WithToasts;
    protected WeeklyCoverageReportService $service;
    protected ProgramService $programService;

    public $report_id = null;
    public $program_id;
    public $nbr_hours_done = 0;
    public $nbr_lesson_done = 0;
    public $nbr_lesson_dig_done = 0;
    public $nbr_tp_done = 0;
    public $nbr_tp_dig_done = 0;
    public $returnUrl = null;

    public function mount($id = null)
    {
        $this->report_id = $id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('weekly-coverage.index');

        // Si c'est une édition, charger le rapport
        if ($this->report_id) {
            $report = $this->service->find($this->report_id);
            $this->program_id = $report->program_id;
            $this->nbr_hours_done = $report->nbr_hours_done;
            $this->nbr_lesson_done = $report->nbr_lesson_done;
            $this->nbr_lesson_dig_done = $report->nbr_lesson_dig_done;
            $this->nbr_tp_done = $report->nbr_tp_done;
            $this->nbr_tp_dig_done = $report->nbr_tp_dig_done;
        }
    }

    public function boot()
    {
        $this->service = app(WeeklyCoverageReportService::class);
        $this->programService = app(ProgramService::class);
    }

    public function save()
    {
        $this->validate([
            'program_id' => 'required|exists:programs,id',
            'nbr_hours_done' => 'required|integer|min:0',
            'nbr_lesson_done' => 'required|integer|min:0',
            'nbr_lesson_dig_done' => 'required|integer|min:0',
            'nbr_tp_done' => 'required|integer|min:0',
            'nbr_tp_dig_done' => 'required|integer|min:0',
        ]);

        $data = [
            'program_id' => $this->program_id,
            'nbr_hours_done' => $this->nbr_hours_done,
            'nbr_lesson_done' => $this->nbr_lesson_done,
            'nbr_lesson_dig_done' => $this->nbr_lesson_dig_done,
            'nbr_tp_done' => $this->nbr_tp_done,
            'nbr_tp_dig_done' => $this->nbr_tp_dig_done,
        ];

        if ($this->report_id) {
            // Édition
            $this->service->update($this->report_id, $data);
            $this->toastSuccess(__('Rapport hebdomadaire modifié avec succès'), __('Succès'));
            $this->redirect($this->returnUrl);
        } else {
            // Création
            $this->service->create($data);
            $this->toastSuccess(__('Rapport hebdomadaire créé avec succès'), __('Succès'));
            $this->redirect($this->returnUrl);
        }
    }

    private function getProgram()
    {
        return $this->programService->find($this->program_id);
    }

    public function render()
    {
        $program = null;
        $isEditing = $this->report_id !== null;

        if ($this->program_id) {
            $program = $this->getProgram();
            if ($program) {
                $program->load('schoolClass', 'subject');
            }
        }

        return view('livewire.weekly-coverage.form', [
            'program' => $program,
            'isEditing' => $isEditing,
        ]);
    }
}
