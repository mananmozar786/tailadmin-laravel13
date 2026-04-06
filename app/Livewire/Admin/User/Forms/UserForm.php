<?php

namespace App\Livewire\Admin\User\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Illuminate\Support\Facades\Hash;

class UserForm extends Form
{
    public ?User $user = null;

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $status = 'active';
    public $roles = [];
    public $gender = '';

    // New location and contact fields
    public $address = '';
    public $city_id = '';
    public $state_id = '';
    public $country_id = '';
    public $zipcode = '';
    public $phone_country_code = '';
    public $phone = '';

    public function setUser(User $user)
    {
        $this->user = $user;

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->gender = $user->gender;
        $this->roles = $user->roles->pluck('name')->toArray();

        // Populate location and contact fields
        $this->address = $user->address;
        $this->city_id = $user->city_id;
        $this->state_id = $user->state_id;
        $this->country_id = $user->country_id;
        $this->zipcode = $user->zipcode;
        $this->phone_country_code = $user->phone_country_code;
        $this->phone = $user->phone;
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
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
            'password' => $this->user ? 'nullable|min:8' : 'required|min:8',
            'status' => 'required|in:active,inactive',
            'gender' => 'nullable|in:male,female,other',
            'roles' => 'required|array|min:1',
            'address' => 'nullable|string|max:500',
            'city_id' => 'nullable|exists:cities,id',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'nullable|exists:countries,id',
            'zipcode' => 'nullable|string|max:10',
            'phone_country_code' => 'nullable|string|max:5',
            'phone' => 'nullable|string|max:15',
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
            'gender' => $this->gender,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'zipcode' => $this->zipcode,
            'phone_country_code' => $this->phone_country_code,
            'phone' => $this->phone,
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
            'gender' => $this->gender,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'zipcode' => $this->zipcode,
            'phone_country_code' => $this->phone_country_code,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);
        $this->user->syncRoles($this->roles);
    }
}
