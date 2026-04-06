<?php

namespace App\Livewire\Admin\Role;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public Role $role;
    public string $name = '';
    public string $guard_name = 'web';
    public array $selectedPermissions = [];

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name,' . $this->role->id,
            'guard_name' => 'required',
            'selectedPermissions' => 'array',
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->role->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        $this->role->syncPermissions($this->selectedPermissions);

        session()->flash('success', 'Role updated successfully.');
        $this->redirectRoute('admin.roles.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $permissions = Permission::where('guard_name', $this->guard_name)->get();

        return view('livewire.admin.role.edit', [
            'permissions' => $permissions,
        ]);
    }
}
