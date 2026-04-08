<?php

namespace App\Livewire\Admin\Category\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Category $category = null;

    public $title = '';
    public $subtitle = '';
    public $status = 'active';

    public function setCategory(Category $category)
    {
        $this->category = $category;
        $this->title = $category->title;
        $this->subtitle = $category->subtitle;
        $this->status = $category->status;
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'title')->ignore($this->category?->id),
            ],
            'subtitle' => 'nullable|string|max:255',
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
