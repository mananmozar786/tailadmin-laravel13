<div class="space-y-6">
    <!-- Breadcrumb -->
    <x-common.page-breadcrumb :pageTitle="'Edit Permission'" :activePage="'Permissions'" />

    <!-- Form Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Permission Information
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Modify permission name and guard.
            </p>
        </div>

        <form wire:submit="update" class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Permission Name -->
                <x-ui.input 
                    label="Permission Name" 
                    wire:model="name" 
                    placeholder="e.g. view users" 
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

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.permissions.index') }}" wire:navigate>
                    <x-ui.button variant="secondary">
                        Cancel
                    </x-ui.button>
                </a>
                <x-ui.button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Update Permission</span>
                    <span wire:loading>Updating...</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</div>
