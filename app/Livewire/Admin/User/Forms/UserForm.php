<?php

namespace App\Livewire\Admin\User\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Illuminate\Support\Facades\Hash;

class UserForm extends Form
{
    public ?User $user;

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $status = 'active';
    public $roles = [];

    public function setUser(User $user)
    {
        $this->user = $user;

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->roles = $user->roles->pluck('name')->toArray();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user ?? null),
            ],
            'password' => $this->user ? 'nullable|min:8' : 'required|min:8',
            'status' => 'required|in:active,inactive',
            'roles' => 'required|array|min:1',
        ];
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->status,
        ]);

        $user->assignRole($this->roles);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'status' => $this->status,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);
        $this->user->syncRoles($this->roles);
    }
}
