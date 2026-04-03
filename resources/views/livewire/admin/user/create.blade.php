<div class="space-y-6">
    <!-- Breadcrumb -->
    <x-common.page-breadcrumb :pageTitle="'Add New User'" :activePage="'Users'" />

    <!-- Form Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                User Information
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Enter user details below to create a new account.
            </p>
        </div>

        <form wire:submit="save" class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- First Name -->
                <x-ui.input 
                    label="First Name" 
                    wire:model="form.first_name" 
                    placeholder="John" 
                    required 
                    :error="$errors->first('form.first_name')" 
                />

                <!-- Last Name -->
                <x-ui.input 
                    label="Last Name" 
                    wire:model="form.last_name" 
                    placeholder="Doe" 
                    required 
                    :error="$errors->first('form.last_name')" 
                />

                <!-- Email -->
                <x-ui.input 
                    type="email" 
                    label="Email Address" 
                    wire:model="form.email" 
                    placeholder="john.doe@example.com" 
                    required 
                    :error="$errors->first('form.email')" 
                />

                <!-- Password -->
                <x-ui.input 
                    type="password" 
                    label="Password" 
                    wire:model="form.password" 
                    placeholder="Min. 8 characters" 
                    required 
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
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5"
                                >
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucwords($role->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('form.roles')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
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

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.users.index') }}" wire:navigate>
                    <x-ui.button variant="secondary">
                        Cancel
                    </x-ui.button>
                </a>
                <x-ui.button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Create User</span>
                    <span wire:loading>Creating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
