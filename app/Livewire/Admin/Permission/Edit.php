<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    public Permission $permission;
    public string $name = '';
    public string $guard_name = 'web';

    public function mount(Permission $permission): void
    {
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|unique:permissions,name,' . $this->permission->id,
            'guard_name' => 'required',
        ];
    }

    public function update(): void
    {
        $this->validate();

        $this->permission->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        session()->flash('success', 'Permission updated successfully.');
        $this->redirectRoute('admin.permissions.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.permission.edit');
    }
}
