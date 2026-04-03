@props([
    'field' => null,
    'sortField' => null,
    'sortDirection' => null,
    'label' => '',
])

<th 
    @if($field) 
        wire:click="sortBy('{{ $field }}')" 
        class="cursor-pointer group px-5 py-4 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 transition hover:text-gray-700 dark:hover:text-white"
    @else
        class="px-5 py-4 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400"
    @endif
>
    <div class="flex items-center gap-1">
        <span>{{ $label }}</span>
        
        @if($field)
            <span class="transition-opacity duration-200 {{ $sortField === $field ? 'opacity-100' : 'opacity-0 group-hover:opacity-50' }}">
                @if($sortField === $field && $sortDirection === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.57a.75.75 0 01-1.08-1.04l5.25-5.25a.75.75 0 011.08 0l5.25 5.25a.75.75 0 11-1.08 1.04l-3.96-3.958V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                    </svg>
                @elseif($sortField === $field && $sortDirection === 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-3.958a.75.75 0 111.08 1.04l-5.25 5.25a.75.75 0 01-1.08 0l-5.25-5.25a.75.75 0 111.08-1.04l3.96 3.958V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 opacity-30">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-3.958a.75.75 0 111.08 1.04l-5.25 5.25a.75.75 0 01-1.08 0l-5.25-5.25a.75.75 0 111.08-1.04l3.96 3.958V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                    </svg>
                @endif
            </span>
        @endif
    </div>
</th>
