@props([
    'variant' => 'primary', // primary, success, warning, danger, gray
])

@php
    $variants = [
        'primary' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-500',
        'success' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-500',
        'warning' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-500',
        'danger' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-500',
        'gray' => 'bg-gray-50 text-gray-700 dark:bg-white/5 dark:text-white/60',
    ];

    $classes = 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
