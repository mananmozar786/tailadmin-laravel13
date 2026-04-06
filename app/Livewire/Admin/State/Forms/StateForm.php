<?php

namespace App\Livewire\Admin\State\Forms;

use App\Models\State;
use Illuminate\Validation\Rule;
use Livewire\Form;

class StateForm extends Form
{
    public ?State $state = null;

    public $country_id = '';
    public $name = '';
    public $state_code = '';
    public $status = 'active';

    public function setState(State $state)
    {
        $this->state = $state;

        $this->country_id = $state->country_id;
        $this->name = $state->name;
        $this->state_code = $state->state_code;
        $this->status = $state->status;
    }

    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'state_code' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function store()
    {
        $this->validate();

        State::create($this->except('state'));

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->state->update($this->except('state'));
    }
}
