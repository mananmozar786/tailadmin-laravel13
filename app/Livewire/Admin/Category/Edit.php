<?php

namespace App\Livewire\Admin\Category;

use App\Livewire\Admin\Category\Forms\CategoryForm;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CategoryForm $form;

    public function mount(Category $category)
    {
        $this->form->setCategory($category);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('success', 'Category updated successfully.');

        return $this->redirect(route('admin.categories.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.category.edit');
    }
}
