<?php

namespace App\Livewire\Admin\Permission;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    public string $name = '';
    public string $guard_name = 'web';

    protected $rules = [
        'name' => 'required|unique:permissions,name',
        'guard_name' => 'required',
    ];

    public function save(): void
    {
        $this->validate();

        Permission::create([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        session()->flash('success', 'Permission created successfully.');
        $this->redirectRoute('admin.permissions.index');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.permission.create');
    }
}
