<?php

namespace App\Livewire\Admin\Country;

use App\Models\Country;
use App\Livewire\Admin\Country\Forms\CountryForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CountryForm $form;

    public function mount(Country $country)
    {
        $this->form->setCountry($country);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('success', 'Country updated successfully.');

        return $this->redirect(route('admin.countries.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.country.edit');
    }
}
