<?php

namespace App\Livewire\Establishments;

use App\Services\EstablishmentService;
use Livewire\Component;

/**
 * Establishments Form Component
 */
class Form extends Component
{
    public $establishmentId = null;
    public $name = '';
    public $code = '';
    public $address = '';
    public $phone = '';
    public $email = '';
    public $returnUrl = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50' . ($this->establishmentId ? "|unique:establishments,code,{$this->establishmentId}" : '|unique:establishments'),
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ];
    }

    public function mount(EstablishmentService $service, $id = null)
    {
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('establishments.index');

        if ($id) {
            $establishment = $service->find($id);
            if ($establishment) {
                $this->establishmentId = $establishment->id;
                $this->name = $establishment->name;
                $this->code = $establishment->code;
                $this->address = $establishment->address;
                $this->phone = $establishment->phone;
                $this->email = $establishment->email;
            }
        }
    }

    public function save(EstablishmentService $service)
    {
        $this->validate();

        if ($this->establishmentId) {
            $service->update($this->establishmentId, [
                'name' => $this->name,
                'code' => $this->code,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);
            $this->dispatch('notify', message: 'Établissement mis à jour avec succès');
        } else {
            $service->create([
                'name' => $this->name,
                'code' => $this->code,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);
            $this->dispatch('notify', message: 'Établissement créé avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        return view('livewire.establishments.form');
    }
}
