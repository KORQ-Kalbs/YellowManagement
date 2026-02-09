@props(['type' => 'info'])

@php
$typeClasses = [
    'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
    'warning' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ' . $typeClasses[$type]]) }}>
    {{ $slot }}
</span>
