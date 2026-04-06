<div class="space-y-6">
    <!-- Breadcrumb -->
    <x-common.page-breadcrumb :pageTitle="'Edit User'" :activePage="'Users'" />

    <!-- Form Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                User Information
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Update user details and permissions.
            </p>
        </div>

        <form wire:submit="save" class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- First Name -->
                <x-ui.input 
                    label="First Name" 
                    wire:model="form.first_name" 
                    required 
                    :error="$errors->first('form.first_name')" 
                />

                <!-- Last Name -->
                <x-ui.input 
                    label="Last Name" 
                    wire:model="form.last_name" 
                    required 
                    :error="$errors->first('form.last_name')" 
                />

                <!-- Email -->
                <x-ui.input 
                    type="email" 
                    label="Email Address" 
                    wire:model="form.email" 
                    required 
                    :error="$errors->first('form.email')" 
                />

                <!-- Password -->
                <x-ui.input 
                    type="password" 
                    label="Password" 
                    wire:model="form.password" 
                    placeholder="Leave blank to keep current" 
                    :error="$errors->first('form.password')" 
                />

                <!-- Roles -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white/90">
                        Assign Roles <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($roles as $role)
                            <label class="inline-flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    wire:model="form.roles" 
                                    value="{{ $role->name }}" 
                                    @checked(in_array($role->name, $form->roles))
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5"
                                >
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucwords($role->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Status -->
                <x-ui.select 
                    label="Account Status" 
                    wire:model="form.status" 
                    required 
                    :error="$errors->first('form.status')"
                >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </x-ui.select>
            </div>

            <!-- Location & Contact Section -->
            <div class="mt-8 border-t border-gray-100 pt-6 dark:border-gray-800">
                <h4 class="mb-4 text-sm font-medium text-gray-800 dark:text-white/90">
                    Location & Contact Details
                </h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Country -->
                    <x-ui.select 
                        label="Country" 
                        wire:model.live="form.country_id" 
                        :error="$errors->first('form.country_id')"
                    >
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </x-ui.select>

                    <!-- State -->
                    <x-ui.select 
                        label="State" 
                        wire:model.live="form.state_id" 
                        :error="$errors->first('form.state_id')"
                        :disabled="!$form->country_id"
                    >
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </x-ui.select>

                    <!-- City -->
                    <x-ui.select 
                        label="City" 
                        wire:model="form.city_id" 
                        :error="$errors->first('form.city_id')"
                        :disabled="!$form->state_id"
                    >
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </x-ui.select>

                    <!-- Zipcode -->
                    <x-ui.input 
                        label="Zipcode" 
                        wire:model="form.zipcode" 
                        placeholder="12345" 
                        :error="$errors->first('form.zipcode')" 
                    />

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                        <textarea 
                            wire:model="form.address" 
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                            rows="3"
                            placeholder="Street address, building, etc."
                        ></textarea>
                        @error('form.address')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Country Code -->
                    <x-ui.input 
                        label="Phone Country Code" 
                        wire:model="form.phone_country_code" 
                        placeholder="+1" 
                        :error="$errors->first('form.phone_country_code')" 
                    />

                    <!-- Phone -->
                    <x-ui.input 
                        label="Phone Number" 
                        wire:model="form.phone" 
                        placeholder="1234567890" 
                        :error="$errors->first('form.phone')" 
                    />
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.users.index') }}" wire:navigate>
                    <x-ui.button variant="secondary">
                        Cancel
                    </x-ui.button>
                </a>
                <x-ui.button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Update User</span>
                    <span wire:loading>Updating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
