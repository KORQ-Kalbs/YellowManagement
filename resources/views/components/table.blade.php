@props(['striped' => true, 'hover' => true])

<!-- Responsive Table Wrapper -->
<div class="w-full overflow-x-auto rounded-lg shadow">
    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left text-gray-600 dark:text-gray-400']) }}>
        {{ $slot }}
    </table>
</div>
