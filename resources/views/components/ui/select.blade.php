@props([
    'label' => '',
    'name' => '',
    'options' => [],
    'required' => false,
    'disabled' => false,
    'error' => '',
    'placeholder' => 'Select an option',
])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-white/90">
            {{ $label }} @if($required)<span class="text-red-500">*</span> @endif
        </label>
    @endif

    <div class="relative">
        <select 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-[#1C2434] dark:text-white/90 dark:focus:border-blue-500 dark:focus:ring-blue-500/10' . ($error ? ' border-red-500 focus:border-red-500 focus:ring-red-100 dark:border-red-500/50 dark:focus:border-red-500/50 dark:focus:ring-red-500/10' : '')]) }}>
            
            @if($placeholder)
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif

            {{ $slot }}
        </select>
        
        @if($error)
            <div class="mt-1 flex items-center gap-1 text-xs text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>{{ $error }}</span>
            </div>
        @endif
    </div>
</div>
