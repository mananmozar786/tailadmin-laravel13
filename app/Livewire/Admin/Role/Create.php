<?php

namespace App\Livewire\Admin\Role;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name = '';
    public string $guard_name = 'web';
    public array $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|unique:roles,name',
        'guard_name' => 'required',
        'selectedPermissions' => 'array',
    ];

    public function save(): void
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        if (!empty($this->selectedPermissions)) {
            $role->syncPermissions($this->selectedPermissions);
        }

        session()->flash('success', 'Role created successfully.');
        $this->redirectRoute('admin.roles.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $permissions = Permission::all()->groupBy('guard_name');

        return view('livewire.admin.role.create', [
            'permissions' => $permissions,
        ]);
    }
}
