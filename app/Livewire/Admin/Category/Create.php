<?php

namespace App\Livewire\Admin\Category;

use App\Livewire\Admin\Category\Forms\CategoryForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public CategoryForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('success', 'Category created successfully.');

        return $this->redirect(route('admin.categories.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.category.create');
    }
}
