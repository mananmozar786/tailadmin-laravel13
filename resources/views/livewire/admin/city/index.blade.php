<div class="space-y-6">
    <x-common.page-breadcrumb :pageTitle="'Location Management'" :activePage="'Cities'" />

    <!-- Error/Success Messages -->
    @if (session('success'))
        <div class="flex items-center gap-2 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-4 p-5 md:flex-row md:items-center md:justify-between lg:p-6 border-b border-gray-100 dark:border-gray-800/50">
            <div class="flex-1 max-w-lg">
                <!-- Search -->
                <div class="relative w-full">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg wire:loading.remove wire:target="search" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <svg wire:loading wire:target="search" class="h-5 w-5 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <input 
                        wire:model.live.debounce.500ms="search" 
                        type="text" 
                        placeholder="Search by name..." 
                        class="pl-11 w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 text-sm transition-all focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-white/5 dark:text-white/90 dark:focus:border-blue-500"
                    />
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Filters Button -->
                <button 
                    x-on:click="$dispatch('open-drawer', 'city-filters')"
                    class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-50 hover:border-gray-300 active:scale-95 dark:border-gray-700 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    Filters
                    @if($country_id || $state_id || $status || $showDeleted || $perPage != 10)
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white">
                            {{ ($country_id ? 1 : 0) + ($state_id ? 1 : 0) + ($status ? 1 : 0) + ($showDeleted ? 1 : 0) + ($perPage != 10 ? 1 : 0) }}
                        </span>
                    @endif
                </button>

                <!-- Add Button -->
                <a href="{{ route('admin.cities.create') }}" wire:navigate>
                    <x-ui.button class="rounded-xl px-5 py-3 shadow-lg shadow-blue-500/20">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="mr-2 h-5 w-5">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                       </svg>
                       Add New City
                    </x-ui.button>
                </a>
            </div>
        </div>

        <x-ui.table>
            <x-slot name="thead">
                <x-ui.table-header label="City Name" field="name" :sortField="$sortField" :sortDirection="$sortDirection" />
                <x-ui.table-header label="State" field="state_name" :sortField="$sortField" :sortDirection="$sortDirection" />
                <x-ui.table-header label="Country" field="country_name" :sortField="$sortField" :sortDirection="$sortDirection" />
                <x-ui.table-header label="Status" field="status" :sortField="$sortField" :sortDirection="$sortDirection" />
                <x-ui.table-header label="Actions" />
            </x-slot>

            @forelse($cities as $city)
                <tr class="transition-all hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                    <td class="px-5 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-800 dark:text-white/90">{{ $city->name }}</span>
                            <span class="text-xs text-gray-500">ID: #{{ $city->id }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $city->state->name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $city->state->country->name }}</td>
                    <td class="px-5 py-4">
                        @php
                            $statusClasses = match($city->status) {
                                'active' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-500',
                                'inactive' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-500',
                                default => 'bg-gray-50 text-gray-700 dark:bg-white/5 dark:text-white/90',
                            };
                        @endphp
                        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full fill-current {{ $city->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ ucwords($city->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                             @if($showDeleted)
                                <button wire:click="restore({{ $city->id }})" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-blue-500 hover:text-blue-500 dark:border-gray-800 dark:text-gray-400 dark:hover:border-blue-500" title="Restore">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDeletion({{ $city->id }})" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-red-500 hover:text-red-500 dark:border-gray-800 dark:text-gray-400 dark:hover:border-red-500" title="Force Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('admin.cities.edit', $city->id) }}" wire:navigate class="group flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-blue-500 hover:text-blue-500 dark:border-gray-800 dark:text-gray-400 dark:hover:border-blue-500" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <button wire:click="confirmDeletion({{ $city->id }})" class="group flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-red-500 hover:text-red-500 dark:border-gray-800 dark:text-gray-400 dark:hover:border-red-500" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center">No cities found</td>
                </tr>
            @endforelse
        </x-ui.table>

        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $cities->onEachSide(1)->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    <!-- Filter Drawer -->
    <x-ui.drawer name="city-filters" title="City Filters">
        <div class="space-y-6">
            <!-- Sorting -->
            <div>
                <label for="filterField" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    Sort By Field
                </label>
                <select 
                    wire:model="sortField" 
                    id="filterField" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="id">ID (Default)</option>
                    <option value="name">Name</option>
                    <option value="state_name">State</option>
                    <option value="country_name">Country</option>
                    <option value="status">Status</option>
                </select>
            </div>

            <div>
                <label for="filterFieldOrder" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    Sort Direction
                </label>
                <select 
                    wire:model="sortDirection" 
                    id="filterFieldOrder" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>

            <!-- Records Per Page -->
            <div>
                <label for="perPage" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    Records Per Page
                </label>
                <select 
                    wire:model="perPage" 
                    id="perPage" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <!-- Country Filter -->
            <div>
                <label for="country_filter" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    Country
                </label>
                <select 
                    wire:model.live="country_id" 
                    id="country_filter" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="">All Countries</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- State Filter -->
            <div>
                <label for="state_filter" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    State
                </label>
                <select 
                    wire:model="state_id" 
                    id="state_filter" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="">All States</option>
                    @foreach($states as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status_filter" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white/90">
                    Status
                </label>
                <select 
                    wire:model="status" 
                    id="status_filter" 
                    class="w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Trash Toggle -->
            <div 
                x-data="{ localShowDeleted: @js($showDeleted) }"
                class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-white/5"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90">Trash Only</h4>
                        <p class="text-xs text-gray-500">Show only deleted cities</p>
                    </div>
                    <button 
                        type="button"
                        x-on:click="localShowDeleted = !localShowDeleted; $nextTick(() => { $refs.showDeletedInput.dispatchEvent(new Event('change', { bubbles: true })) })"
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
                        :class="localShowDeleted ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                    >
                        <span 
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="localShowDeleted ? 'translate-x-5' : 'translate-x-0'"
                        ></span>
                    </button>
                    <input type="checkbox" wire:model="showDeleted" x-model="localShowDeleted" x-ref="showDeletedInput" class="hidden">
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex items-center justify-between gap-3">
                <button 
                    wire:click="resetFilters" 
                    x-on:click="close()"
                    class="w-full rounded-xl border border-gray-200 bg-white py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/5 dark:text-white"
                >
                    Reset All
                </button>
                <button 
                    wire:click="$refresh"
                    wire:loading.attr="disabled"
                    x-on:click="close()" 
                    class="w-full rounded-xl bg-blue-600 py-3 text-sm font-semibold text-white hover:bg-blue-700 shadow-lg shadow-blue-500/30 disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="$refresh">Apply Filters</span>
                    <span wire:loading wire:target="$refresh" class="flex items-center justify-center gap-2">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Applying...
                    </span>
                </button>
            </div>
        </x-slot>
    </x-ui.drawer>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal name="confirm-city-deletion" maxWidth="md" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white/90">
                Are you sure you want to delete this city?
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $showDeleted ? 'This action will permanently delete the city. This cannot be undone.' : 'The city will be soft-deleted. You can restore it later from the trash.' }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', 'confirm-city-deletion')">
                    Cancel
                </x-ui.button>
                <x-ui.button variant="danger" wire:click="delete">
                    {{ $showDeleted ? 'Permanently Delete' : 'Delete City' }}
                </x-ui.button>
            </div>
        </div>
    </x-ui.modal>
</div>
