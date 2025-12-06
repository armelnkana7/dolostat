<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissions extends Component
{
    public $roles = [];
    public $permissions = [];
    public $selectedRole = null;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function selectRole($roleId)
    {
        $this->selectedRole = $roleId;
        $role = Role::find($roleId);
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function updatePermissions()
    {
        if (!$this->selectedRole) {
            $this->addError('selectedRole', __('Veuillez sélectionner un rôle'));
            return;
        }

        $role = Role::find($this->selectedRole);
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('message', __('Permissions mises à jour avec succès'));
    }

    public function render()
    {
        return view('livewire.admin.role-permissions');
    }
}
