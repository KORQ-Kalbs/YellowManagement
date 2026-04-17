@props(['hover' => true])

<tr {{ $attributes->merge(['class' => (($hover) ? 'app-hover transition-colors' : '') . ' app-surface']) }}>
    {{ $slot }}
</tr>
