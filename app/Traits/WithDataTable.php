<?php

namespace App\Traits;

use Livewire\WithPagination;

trait WithDataTable
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
    public string $sortField = 'id';
    public string $sortDirection = 'desc';

    /**
     * Reset pagination when search is updated.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when per page is updated.
     */
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * Toggle sort direction or change sort field.
     */
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Reset all filters to their default state.
     */
    public function resetFilters(): void
    {
        $this->reset(['search', 'perPage', 'sortField', 'sortDirection']);
        
        // Custom reset logic for components can be added via a resetHook 
        if (method_exists($this, 'resetCustomFilters')) {
            $this->resetCustomFilters();
        }

        $this->resetPage();
    }

    /**
     * Get the default query string configuration.
     */
    protected function queryStringWithDataTable(): array
    {
        return [
            'search' => ['except' => ''],
            'perPage' => ['except' => 10],
            'sortField' => ['except' => 'id'],
            'sortDirection' => ['except' => 'desc'],
        ];
    }
}
