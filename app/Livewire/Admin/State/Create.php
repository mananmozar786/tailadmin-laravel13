<?php

namespace App\Livewire\Admin\State;

use App\Models\Country;
use App\Livewire\Admin\State\Forms\StateForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public StateForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('success', 'State created successfully.');

        return $this->redirect(route('admin.states.index'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.state.create', [
            'countries' => Country::active()->get(),
        ]);
    }
}
