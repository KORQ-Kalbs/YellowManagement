@props(['hover' => true])

<tr {{ $attributes->merge(['class' => (($hover) ? 'hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors' : '') . ' bg-white dark:bg-gray-800']) }}>
    {{ $slot }}
</tr>
