@props(['striped' => true, 'hover' => true])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left text-gray-600 dark:text-gray-400']) }}>
        {{ $slot }}
    </table>
</div>
