@props(['icon' => null, 'label' => '', 'value' => '', 'trend' => null, 'trendUp' => true, 'color' => 'blue', 'title' => null])

@php
$colorClasses = [
    'blue' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800',
    'green' => 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 border-green-200 dark:border-green-800',
    'yellow' => 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
    'red' => 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800',
    'purple' => 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 border-purple-200 dark:border-purple-800',
];

// If color is a custom class string (not in predefined colors), use it directly
$colorClass = isset($colorClasses[$color]) ? $colorClasses[$color] : $color;
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title ?? $label }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            
            @if($trend)
                <div class="mt-2 flex items-center space-x-1">
                    @if($trendUp)
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $trend }}</span>
                    @else
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-sm font-semibold text-red-600 dark:text-red-400">{{ $trend }}</span>
                    @endif
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="rounded-lg p-3 {{ $colorClass }}">
                {{ $icon }}
            </div>
        @endif
    </div>
</div>
