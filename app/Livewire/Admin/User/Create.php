<?php

namespace App\Livewire\Admin\User;

use App\Livewire\Admin\User\Forms\UserForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public UserForm $form;

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
        ]);
    }
}
