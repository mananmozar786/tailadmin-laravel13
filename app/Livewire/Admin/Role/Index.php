<?php

namespace App\Livewire\Admin\Role;

use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithDataTable;

    public string $guard = '';
    public $roleIdBeingDeleted = null;

    protected function queryString(): array
    {
        return array_merge($this->queryStringWithDataTable(), [
            'guard' => ['except' => ''],
        ]);
    }

    public function updatedGuard(): void
    {
        $this->resetPage();
    }

    /**
     * Reset custom filters for this component.
     */
    public function resetCustomFilters(): void
    {
        $this->reset(['guard']);
    }

    public function confirmDeletion($id): void
    {
        $this->roleIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-role-deletion');
    }

    public function delete(): void
    {
        $role = Role::findOrFail($this->roleIdBeingDeleted);
        
        if ($role->name === 'super admin') {
            session()->flash('error', 'The Super Admin role cannot be deleted.');
        } else {
            $role->delete();
            session()->flash('success', 'Role deleted successfully.');
        }

        $this->roleIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-role-deletion');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $roles = Role::query()
            ->withCount('permissions')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('guard_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->guard, fn($q) => $q->where('guard_name', $this->guard))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.role.index', [
            'roles' => $roles,
        ]);
    }
}
