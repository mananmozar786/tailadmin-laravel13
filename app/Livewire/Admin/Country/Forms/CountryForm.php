<?php

namespace App\Livewire\Admin\Country\Forms;

use App\Models\Country;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CountryForm extends Form
{
    public ?Country $country = null;

    public $name = '';
    public $short_code = '';
    public $phone_code = '';
    public $status = 'active';

    public function setCountry(Country $country)
    {
        $this->country = $country;

        $this->name = $country->name;
        $this->short_code = $country->short_code;
        $this->phone_code = $country->phone_code;
        $this->status = $country->status;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('countries', 'name')->ignore($this->country?->id),
            ],
            'short_code' => 'required|string|max:10',
            'phone_code' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function store()
    {
        $this->validate();

        Country::create($this->except('country'));

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->country->update($this->except('country'));
    }
}
