<?php

namespace App\Livewire\Admin\Country;

use App\Models\Country;
use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable;

    public string $status = '';
    public bool $showDeleted = false;
    public $countryIdBeingDeleted = null;

    /**
     * Define the query string configuration.
     */
    protected function queryString(): array
    {
        return array_merge($this->queryStringWithDataTable(), [
            'status' => ['except' => ''],
            'showDeleted' => ['except' => false],
        ]);
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
     * Reset custom filters.
     */
    public function resetCustomFilters(): void
    {
        $this->reset(['status', 'showDeleted']);
    }

    public function confirmDeletion($id): void
    {
        $this->countryIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-country-deletion');
    }

    public function delete(): void
    {
        $country = Country::withTrashed()->findOrFail($this->countryIdBeingDeleted);

        if ($country->trashed()) {
            $country->forceDelete();
            session()->flash('success', 'Country permanently deleted.');
        } else {
            $country->delete();
            session()->flash('success', 'Country soft deleted.');
        }

        $this->countryIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-country-deletion');
    }

    public function restore($id): void
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->restore();
        session()->flash('success', 'Country restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $countries = Country::query()
            ->when($this->showDeleted, fn($q) => $q->onlyTrashed())
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('short_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.country.index', [
            'countries' => $countries,
        ]);
    }
}
