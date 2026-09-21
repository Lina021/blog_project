@props(['variant' => 'primary', 'href' => null])

@php
    $classes = 'inline-flex items-center rounded px-3 py-1.5 text-sm font-medium transition ' . match ($variant) {
        'secondary' => 'border border-ink bg-white text-ink hover:bg-page',
        default => 'bg-ink text-white hover:bg-brand-dark',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
