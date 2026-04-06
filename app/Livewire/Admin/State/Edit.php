<?php

namespace App\Livewire\Admin\State;

use App\Models\Country;
use App\Models\State;
use App\Livewire\Admin\State\Forms\StateForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public StateForm $form;

    public function mount(State $state)
    {
        $this->form->setState($state);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('success', 'State updated successfully.');

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
