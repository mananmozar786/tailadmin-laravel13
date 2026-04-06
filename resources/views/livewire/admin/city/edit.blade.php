<div class="space-y-6">
    <x-common.page-breadcrumb :pageTitle="'City Management'" :activePage="'Create/Edit'" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium">Country <span class="text-red-500">*</span></label>
                    <select wire:model.live="form.country_id" class="w-full rounded-lg border p-2.5 text-sm dark:bg-white/5">
                        <option value="">Select Country</option>
                        @foreach($countries as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('form.country_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">State <span class="text-red-500">*</span></label>
                    <select wire:model="form.state_id" class="w-full rounded-lg border p-2.5 text-sm dark:bg-white/5">
                        <option value="">Select State</option>
                        @foreach($states as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('form.state_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">City Name <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="form.name" class="w-full rounded-lg border p-2.5 text-sm dark:bg-white/5">
                    @error('form.name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Status <span class="text-red-500">*</span></label>
                    <select wire:model="form.status" class="w-full rounded-lg border p-2.5 text-sm dark:bg-white/5">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('form.status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.cities.index') }}" wire:navigate>
                    <x-ui.button variant="secondary">Cancel</x-ui.button>
                </a>
                <x-ui.button type="submit">Save City</x-ui.button>
            </div>
        </form>
    </div>
</div>
