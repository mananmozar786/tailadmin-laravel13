<?php

namespace App\Livewire\Admin\City\Forms;

use App\Models\City;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CityForm extends Form
{
    public ?City $city = null;

    public $country_id = '';
    public $state_id = '';
    public $name = '';
    public $status = 'active';

    public function setCity(City $city)
    {
        $this->city = $city;

        $this->state_id = $city->state_id;
        $this->country_id = $city->state->country_id;
        $this->name = $city->name;
        $this->status = $city->status;
    }

    public function rules()
    {
        return [
            'state_id' => 'required|exists:states,id',
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => 'required|in:active,inactive',
        ];
    }

    public function store()
    {
        $this->validate();

        City::create([
            'state_id' => $this->state_id,
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->city->update([
            'state_id' => $this->state_id,
            'name' => $this->name,
            'status' => $this->status,
        ]);
    }
}
