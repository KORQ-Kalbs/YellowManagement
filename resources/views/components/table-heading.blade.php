@props(['class' => ''])

<th {{ $attributes->merge(['class' => 'px-6 py-3 text-xs font-semibold uppercase tracking-wider ' . $class]) }}>
    {{ $slot }}
</th>
