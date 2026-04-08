<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Traits\WithDataTable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable;

    public string $status = '';
    public bool $showDeleted = false;
    public $categoryIdBeingDeleted = null;

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

    public function resetCustomFilters(): void
    {
        $this->reset(['status', 'showDeleted']);
    }

    public function confirmDeletion($id): void
    {
        $this->categoryIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'confirm-category-deletion');
    }

    public function delete(): void
    {
        $category = Category::withTrashed()->findOrFail($this->categoryIdBeingDeleted);

        if ($category->trashed()) {
            $category->forceDelete();
            session()->flash('success', 'Category permanently deleted.');
        } else {
            $category->delete();
            session()->flash('success', 'Category soft deleted.');
        }

        $this->categoryIdBeingDeleted = null;
        $this->dispatch('close-modal', 'confirm-category-deletion');
    }

    public function restore($id): void
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        session()->flash('success', 'Category restored successfully.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $categories = Category::query()
            ->when($this->showDeleted, fn($q) => $q->onlyTrashed())
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('subtitle', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($this->sortField === 'name' ? 'title' : $this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.category.index', [
            'categories' => $categories,
        ]);
    }
}
