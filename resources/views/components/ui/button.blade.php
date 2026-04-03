@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, success, danger, outline
    'size' => 'md', // sm, md, lg
    'disabled' => false,
])

@php
    $baseStyles = 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-all duration-300 active:scale-95 disabled:opacity-50 disabled:pointer-events-none';
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-200 dark:shadow-none',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10',
        'success' => 'bg-green-600 text-white hover:bg-green-700 shadow-sm shadow-green-200 dark:shadow-none',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm shadow-red-200 dark:shadow-none',
        'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-white/90 dark:hover:bg-white/5',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }} {{ $disabled ? 'disabled' : '' }}>
    {{ $slot }}
</button>
