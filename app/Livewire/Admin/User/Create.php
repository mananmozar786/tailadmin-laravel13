<?php

namespace App\Livewire\Admin\User;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Livewire\Admin\User\Forms\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public UserForm $form;

    public function updatedFormCountryId($value)
    {
        $this->form->state_id = '';
        $this->form->city_id = '';
    }

    public function updatedFormStateId($value)
    {
        $this->form->city_id = '';
    }

    public function save()
    {
        $this->form->store();

        session()->flash('success', 'User created successfully.');

        return $this->redirect(route('admin.users.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.user.create', [
            'roles' => Role::all(),
            'countries' => Country::active()->get(),
            'states' => $this->form->country_id ? State::active()->where('country_id', $this->form->country_id)->get() : collect(),
            'cities' => $this->form->state_id ? City::active()->where('state_id', $this->form->state_id)->get() : collect(),
        ]);
    }
}
