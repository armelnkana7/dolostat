<?php

namespace App\Livewire\Users;

use App\Models\Department;
use App\Models\Establishment;
use App\Services\UserService;
use Livewire\Component;

/**
 * Users Form Component
 */
class Form extends Component
{
    public $userId = null;
    public $establishment_id = null;
    public $department_id = null;
    public $name = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $returnUrl = null;

    protected function rules()
    {
        if ($this->userId) {
            return [
                'name' => 'required|string|max:255',
                'username' => 'nullable|string|max:255|unique:users,username,' . $this->userId,
                'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
                'password' => 'nullable|string|min:8|confirmed',
                'establishment_id' => 'required|exists:establishments,id',
                'department_id' => 'nullable|exists:departments,id',
            ];
        }

        return [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'establishment_id' => 'required|exists:establishments,id',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }

    public function mount(UserService $service, $id = null)
    {
        $this->establishment_id = session('establishment_id') ?? auth()->user()?->establishment_id;
        // Capture the URL to return to after actions. Store at mount to avoid Livewire ajax request changing previous URL.
        $this->returnUrl = url()->previous() ?? route('users.index');

        if ($id) {
            $user = $service->find($id, ['establishment', 'department']);
            if ($user) {
                $this->userId = $user->id;
                $this->establishment_id = $user->establishment_id;
                $this->department_id = $user->department_id;
                $this->name = $user->name;
                $this->username = $user->username;
                $this->email = $user->email;
            }
        }
    }

    public function save(UserService $service)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'establishment_id' => $this->establishment_id,
            'department_id' => $this->department_id,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->userId) {
            $service->update($this->userId, $data);
            $this->dispatch('notify', message: 'Utilisateur mis à jour avec succès');
        } else {
            $service->create($data);
            $this->dispatch('notify', message: 'Utilisateur créé avec succès');
        }

        $this->redirect($this->returnUrl);
    }

    public function render()
    {
        $establishments = Establishment::all();
        $departments = Department::where('establishment_id', $this->establishment_id)->get();

        return view('livewire.users.form', compact('establishments', 'departments'));
    }
}
