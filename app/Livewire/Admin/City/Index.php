<?php

namespace App\Livewire\Admin\City;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable;

    public string $country_id = '';
    public string $state_id = '';
    public string $status = '';
    public bool $showDeleted = false;
    public $cityIdBeingDeleted = null;

    protected function queryString(): array
    {
        return array_merge($this->queryStringWithDataTable(), [
            'country_id' => ['except' => ''],
            'state_id' => ['except' => ''],
            'status' => ['except' => ''],
            'showDeleted' => ['except' => false],
        ]);
    }

    public function updatedCountryId(): void
    {
        $this->state_id = '';
        $this->resetPage();
    }

    public function updatedStateId(): void
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
        $this->reset(['country_id', 'state_id', 'status', 'showDeleted']);
    }

    public function confirmDeletion($id): void
    {
        $this->cityIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-city-deletion');
    }

    public function delete(): void
    {
        $city = City::withTrashed()->findOrFail($this->cityIdBeingDeleted);

        if ($city->trashed()) {
            $city->forceDelete();
            session()->flash('success', 'City permanently deleted.');
        } else {
            $city->delete();
            session()->flash('success', 'City soft deleted.');
        }

        $this->cityIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-city-deletion');
    }

    public function restore($id): void
    {
        $city = City::onlyTrashed()->findOrFail($id);
        $city->restore();
        session()->flash('success', 'City restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $cities = City::query()
            ->addSelect([
                'state_name' => State::select('name')->whereColumn('states.id', 'cities.state_id')->limit(1),
                'country_name' => State::select('countries.name')
                    ->join('countries', 'states.country_id', '=', 'countries.id')
                    ->whereColumn('states.id', 'cities.state_id')
                    ->limit(1)
            ])
            ->with(['state', 'state.country'])
            ->when($this->showDeleted, fn($q) => $q->onlyTrashed())
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->state_id, fn($q) => $q->where('state_id', $this->state_id))
            ->when($this->country_id, function ($q) {
                $q->whereHas('state', function ($query) {
                    $query->where('country_id', $this->country_id);
                });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.city.index', [
            'cities' => $cities,
            'countries' => Country::all(),
            'states' => $this->country_id ? State::where('country_id', $this->country_id)->get() : [],
        ]);
    }
}
