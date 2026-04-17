@props(['title' => null, 'noPadding' => false, 'class' => ''])

<div {{ $attributes->merge(['class' => 'app-surface rounded-lg shadow border app-border ' . $class]) }}>
    @if($title)
        <div class="px-6 py-4 border-b app-border">
            <h3 class="text-lg font-semibold app-text">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>
</div>
