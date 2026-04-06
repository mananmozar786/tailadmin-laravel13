<?php

namespace App\Livewire\Admin\Category\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Category $category = null;

    public $name = '';
    public $status = 'active';

    public function setCategory(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->status = $category->status;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->category?->id),
            ],
            'status' => 'required|in:active,inactive',
        ];
    }

    public function store()
    {
        $this->validate();

        Category::create($this->except('category'));

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->category->update($this->except('category'));
    }
}
