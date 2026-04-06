<div class="space-y-6">
    <x-common.page-breadcrumb :pageTitle="'Edit Category'" :activePage="'Edit'" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="form.name" class="w-full rounded-lg border border-gray-200 p-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-white/5 dark:text-white">
                    @error('form.name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">Status <span class="text-red-500">*</span></label>
                    <select wire:model="form.status" class="w-full rounded-lg border border-gray-200 p-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-white/5 dark:text-white">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('form.status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800/50 mt-6">
                <a href="{{ route('admin.categories.index') }}" wire:navigate>
                    <x-ui.button variant="secondary" class="rounded-xl px-6">Cancel</x-ui.button>
                </a>
                <x-ui.button type="submit" class="rounded-xl px-6 shadow-lg shadow-blue-500/20">Update Category</x-ui.button>
            </div>
        </form>
    </div>
</div>
