<?php

namespace App\Livewire;

use App\Models\AcademicYear;
use App\Models\Establishment;
use Livewire\Component;

/**
 * AdminSwitcher Component - Allows admins to switch between establishments and academic years
 * 
 * This component displays dropdowns for selecting the current establishment and academic year
 * and stores the selection in the session for use throughout the application.
 * 
 * Livewire 3 compatible - located in app/Livewire/ directory
 */
class AdminSwitcher extends Component
{
    public ?int $selectedEstablishment = null;
    public ?int $selectedAcademicYear = null;
    public $establishments = [];
    public $academicYears = [];

    #[\Livewire\Attributes\On('establishment-changed')]
    public function mount()
    {
        $user = auth()->user();
        $this->selectedEstablishment = session('establishment_id') ?? $user?->establishment_id;
        $this->selectedAcademicYear = session('academic_year_id') ?? $user?->academic_year_id;
        $this->loadEstablishments();
        $this->loadAcademicYears();
    }

    public function loadEstablishments()
    {
        $this->establishments = Establishment::query()
            ->orderBy('name')
            ->get()
            ->map(fn($e) => ['id' => $e->id, 'name' => $e->name])
            ->toArray();
    }

    public function loadAcademicYears()
    {
        $this->academicYears = $this->selectedEstablishment
            ? AcademicYear::where('establishment_id', $this->selectedEstablishment)
            ->orderBy('title', 'desc')
            ->get()
            ->map(fn($y) => ['id' => $y->id, 'title' => $y->title, 'is_active' => $y->is_active])
            ->toArray()
            : [];
    }

    public function updateEstablishment($id)
    {
        $this->selectedEstablishment = (int) $id;
        $this->selectedAcademicYear = null;

        // Persist to session
        session(['establishment_id' => $id, 'academic_year_id' => null]);

        // Persist to database
        auth()->user()->update([
            'establishment_id' => $id,
            'academic_year_id' => null,
        ]);

        $this->loadAcademicYears();
        $this->dispatch('establishment-changed', id: $id);
    }

    public function updateAcademicYear($id)
    {
        $this->selectedAcademicYear = (int) $id;

        // Persist to session
        session(['academic_year_id' => $id]);

        // Persist to database
        auth()->user()->update([
            'academic_year_id' => $id,
        ]);

        $this->dispatch('academic-year-changed', id: $id);
    }

    public function render()
    {
        return view('livewire.admin-switcher');
    }
}
