<?php

namespace App\Livewire\Admin\Permission;

use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    use WithDataTable;

    public string $guard = '';
    public $permissionIdBeingDeleted = null;

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
        $this->permissionIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-permission-deletion');
    }

    public function delete(): void
    {
        $permission = Permission::findOrFail($this->permissionIdBeingDeleted);
        $permission->delete();

        session()->flash('success', 'Permission deleted successfully.');

        $this->permissionIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-permission-deletion');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $permissions = Permission::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('guard_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->guard, fn($q) => $q->where('guard_name', $this->guard))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.permission.index', [
            'permissions' => $permissions,
        ]);
    }
}
