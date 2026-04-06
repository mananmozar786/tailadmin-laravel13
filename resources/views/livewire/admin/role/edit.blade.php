<div class="space-y-6">
    <!-- Breadcrumb -->
    <x-common.page-breadcrumb :pageTitle="'Edit Role'" :activePage="'Roles'" />

    <!-- Form Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Role Information
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Modify role name and guard.
            </p>
        </div>

        <form wire:submit="update" class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                <!-- Role Name -->
                <x-ui.input 
                    label="Role Name" 
                    wire:model="name" 
                    placeholder="e.g. manager" 
                    required 
                    :error="$errors->first('name')" 
                />

                <!-- Guard Name -->
                <x-ui.select 
                    label="Guard Name" 
                    wire:model="guard_name" 
                    required 
                    :error="$errors->first('guard_name')"
                >
                    <option value="web">Web</option>
                    <option value="api">API</option>
                </x-ui.select>
            </div>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90 mb-4">Assign Permissions</h4>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($permissions as $permission)
                        <label class="relative flex items-start p-3 rounded-xl border border-gray-100 bg-gray-50/30 transition-all hover:bg-gray-100/50 dark:border-gray-800 dark:bg-white/5 cursor-pointer group">
                            <div class="flex items-center h-5">
                                <input 
                                    type="checkbox" 
                                    wire:model="selectedPermissions" 
                                    value="{{ $permission->name }}" 
                                    class="h-4.5 w-4.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 transition-colors">
                                    {{ $permission->name }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
                
                @error('selectedPermissions')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.roles.index') }}" wire:navigate>
                    <x-ui.button variant="secondary">
                        Cancel
                    </x-ui.button>
                </a>
                <x-ui.button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Role</span>
                    <span wire:loading>Updating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
