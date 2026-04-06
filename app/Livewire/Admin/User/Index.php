<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithDataTable;

    public string $role = '';
    public string $status = '';
    public bool $showDeleted = false;

    public $userIdBeingDeleted = null;

    /**
     * Define the query string configuration.
     */
    protected function queryString(): array
    {
        return array_merge($this->queryStringWithDataTable(), [
            'role' => ['except' => ''],
            'status' => ['except' => ''],
            'showDeleted' => ['except' => false],
        ]);
    }

    public function updatedRole(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedShowDeleted(): void
    {
        $this->resetPage();
    }

    /**
     * Reset custom filters for this component.
     */
    public function resetCustomFilters(): void
    {
        $this->reset(['role', 'status', 'showDeleted']);
    }

    public function confirmDeletion($id): void
    {
        $this->userIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-user-deletion');
    }

    public function delete(): void
    {
        $user = User::withTrashed()->findOrFail($this->userIdBeingDeleted);

        if ($user->trashed()) {
            $user->forceDelete();
            session()->flash('success', 'User permanently deleted.');
        } else {
            $user->delete();
            session()->flash('success', 'User soft deleted.');
        }

        $this->userIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-user-deletion');
    }

    public function restore($id): void
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success', 'User restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $users = User::query()
            ->when($this->showDeleted, fn($q) => $q->onlyTrashed())
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role, fn($q) => $q->role($this->role))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.user.index', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }
}
