<?php

namespace App\Livewire\Admin\User;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Livewire\Admin\User\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->setUser($user);
    }

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
        $this->form->update();

        session()->flash('success', 'User updated successfully.');

        return $this->redirect(route('admin.users.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.user.edit', [
            'roles' => Role::all(),
            'countries' => Country::active()->get(),
            'states' => $this->form->country_id ? State::active()->where('country_id', $this->form->country_id)->get() : collect(),
            'cities' => $this->form->state_id ? City::active()->where('state_id', $this->form->state_id)->get() : collect(),
        ]);
    }
}
