<?php

namespace App\Livewire\Admin\State;

use App\Models\Country;
use App\Models\State;
use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable;

    public string $country_id = '';
    public string $status = '';
    public bool $showDeleted = false;
    public $stateIdBeingDeleted = null;

    protected function queryString(): array
    {
        return array_merge($this->queryStringWithDataTable(), [
            'country_id' => ['except' => ''],
            'status' => ['except' => ''],
            'showDeleted' => ['except' => false],
        ]);
    }

    public function updatedCountryId(): void
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

    public function resetCustomFilters(): void
    {
        $this->reset(['country_id', 'status', 'showDeleted']);
    }

    public function confirmDeletion($id): void
    {
        $this->stateIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-state-deletion');
    }

    public function delete(): void
    {
        $state = State::withTrashed()->findOrFail($this->stateIdBeingDeleted);

        if ($state->trashed()) {
            $state->forceDelete();
            session()->flash('success', 'State permanently deleted.');
        } else {
            $state->delete();
            session()->flash('success', 'State soft deleted.');
        }

        $this->stateIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-state-deletion');
    }

    public function restore($id): void
    {
        $state = State::onlyTrashed()->findOrFail($id);
        $state->restore();
        session()->flash('success', 'State restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $states = State::query()
            ->addSelect(['country_name' => Country::select('name')->whereColumn('countries.id', 'states.country_id')->limit(1)])
            ->with('country')
            ->when($this->showDeleted, fn($q) => $q->onlyTrashed())
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('state_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->country_id, fn($q) => $q->where('country_id', $this->country_id))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.state.index', [
            'states' => $states,
            'countries' => Country::all(),
        ]);
    }
}
