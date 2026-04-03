<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $status = '';
    public $showDeleted = false;

    public $userIdBeingDeleted = null;
    public $isConfirmingDeletion = false;

    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => ''],
        'showDeleted' => ['except' => false],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRole()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedShowDeleted()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDeletion($id)
    {
        $this->userIdBeingDeleted = $id;
        $this->isConfirmingDeletion = true;
        $this->dispatch('open-modal', 'confirm-user-deletion');
    }

    public function delete()
    {
        $user = User::withTrashed()->findOrFail($this->userIdBeingDeleted);

        if ($user->trashed()) {
            $user->forceDelete();
            session()->flash('success', 'User permanently deleted.');
        } else {
            $user->delete();
            session()->flash('success', 'User soft deleted.');
        }

        $this->isConfirmingDeletion = false;
        $this->userIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-user-deletion');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success', 'User restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = User::query();

        if ($this->showDeleted) {
            $query->onlyTrashed();
        }

        $query->when($this->search, function ($q) {
            $q->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        });

        if ($this->role) {
            $query->role($this->role);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return view('livewire.admin.user.index', [
            'users' => $query->orderBy($this->sortField, $this->sortDirection)->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
