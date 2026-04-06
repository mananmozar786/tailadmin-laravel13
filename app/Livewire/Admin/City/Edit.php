<?php

namespace App\Livewire\Admin\City;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Livewire\Admin\City\Forms\CityForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CityForm $form;
    public $states = [];

    public function mount(City $city)
    {
        $this->form->setCity($city);
        $this->states = State::where('country_id', $this->form->country_id)->active()->get();
    }

    public function updatedFormCountryId($value)
    {
        $this->states = State::where('country_id', $value)->active()->get();
        $this->form->state_id = '';
    }

    public function save()
    {
        $this->form->update();

        session()->flash('success', 'City updated successfully.');

        return $this->redirect(route('admin.cities.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.city.create', [
            'countries' => Country::active()->get(),
        ]);
    }
}
