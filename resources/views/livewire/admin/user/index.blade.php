<div class="space-y-6">
    <!-- Breadcrumb -->
    <x-common.page-breadcrumb :pageTitle="'User Management'" :activePage="'Users'" />

    <!-- Error/Success Messages -->
    @if (session('success'))
        <div class="flex items-center gap-2 rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-500/10 dark:text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Table Header / Filters -->
        <div class="flex flex-col gap-4 p-5 md:flex-row md:items-center md:justify-between lg:p-6">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative w-full max-w-[300px]">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Search users..." 
                        class="pl-10 w-full rounded-lg border border-gray-300 py-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-white/5 dark:text-white/90 dark:focus:border-blue-500 dark:focus:ring-blue-500/10"
                    />
                </div>

                <!-- Role Filter -->
                <select wire:model.live="role" class="rounded-lg border border-gray-300 py-2.5 px-4 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-[#1C2434] dark:text-white/90">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select wire:model.live="status" class="rounded-lg border border-gray-300 py-2.5 px-4 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-[#1C2434] dark:text-white/90">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <!-- Trash Toggle -->
                <button 
                    wire:click="$toggle('showDeleted')" 
                    class="inline-flex items-center gap-2 rounded-lg py-2.5 px-4 text-sm font-medium transition-all {{ $showDeleted ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-500' : 'bg-gray-100 text-gray-700 dark:bg-white/5 dark:text-white/90 hover:bg-gray-200 dark:hover:bg-white/10' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    {{ $showDeleted ? 'Hide Deleted' : 'Show Deleted' }}
                </button>
            </div>

            <!-- Add User Button -->
            <a href="{{ route('admin.users.create') }}" wire:navigate>
                <x-ui.button>
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                   </svg>
                   Add New User
                </x-ui.button>
            </a>
        </div>

        <x-ui.table :headers="['User', 'Email', 'Role', 'Status', 'Actions']">
            @forelse($users as $user)
                <tr>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 overflow-hidden rounded-full border border-gray-100 dark:border-gray-800">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=6366f1&color=fff" alt="Avatar">
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                <span class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $user->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-700 dark:text-white/70">
                        {{ $user->email }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($user->roles as $role)
                                <x-ui.badge variant="primary">{{ $role->name }}</x-ui.badge>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-5 py-4">
                       <x-ui.badge :variant="$user->status === 'active' ? 'success' : 'danger'">
                           {{ ucwords($user->status) }}
                       </x-ui.badge>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            @if($showDeleted)
                                <button wire:click="restore({{ $user->id }})" class="p-1 px-2.5 text-blue-500 hover:text-blue-600 dark:hover:text-blue-400" title="Restore">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    Restore
                                </button>
                                <button wire:click="confirmDeletion({{ $user->id }})" class="p-1.5 text-red-500 hover:text-red-600 dark:hover:text-red-400" title="Force Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('admin.users.edit', $user->id) }}" wire:navigate class="p-1.5 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-500" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <button wire:click="confirmDeletion({{ $user->id }})" class="p-1.5 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center">
                        <div class="flex flex-col items-center justify-center gap-2">
                             <div class="rounded-full bg-gray-50 p-4 dark:bg-white/5">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-gray-400">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.511-3.058 4.125 4.125 0 00-1.637 5.637zM6.75 19.128a9.38 9.38 0 01-2.625.372 9.337 9.337 0 01-4.121-.952 4.125 4.125 0 017.511-3.058 4.125 4.125 0 011.637 5.637zM12 11.25a4.5 4.5 0 100-9 4.5 4.5 0 000 9zM12 18.75a8.25 8.25 0 00-5.712 2.28 1.125 1.125 0 001.424 1.74l.117-.094c.433-.35.91-.63 1.417-.832A8.25 8.25 0 0012 21a8.25 8.25 0 006.512-3.155 1.125 1.125 0 00-1.424-1.74l-.117.094a8.25 8.25 0 00-4.971 2.551z" />
                                 </svg>
                             </div>
                             <p class="font-medium text-gray-700 dark:text-white/80">No users found</p>
                             <p class="text-sm text-gray-500 dark:text-gray-500">Try adjusting your filters or search terms</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal name="confirm-user-deletion" :show="$isConfirmingDeletion" maxWidth="md" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white/90">
                Are you sure you want to delete this user?
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $showDeleted ? 'This action will permanently delete the user and cannot be undone.' : 'The user will be soft-deleted. You can restore them later from the trash.' }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', 'confirm-user-deletion')">
                    Cancel
                </x-ui.button>
                <x-ui.button variant="danger" wire:click="delete">
                    {{ $showDeleted ? 'Permanently Delete' : 'Delete User' }}
                </x-ui.button>
            </div>
        </div>
    </x-ui.modal>
</div>
