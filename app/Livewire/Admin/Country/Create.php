<?php

namespace App\Livewire\Admin\Country;

use App\Livewire\Admin\Country\Forms\CountryForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public CountryForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('success', 'Country created successfully.');

        return $this->redirect(route('admin.countries.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.country.create');
    }
}
