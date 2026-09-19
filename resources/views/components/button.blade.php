@props(['variant' => 'primary', 'href' => null])

@php
    $classes = 'inline-flex items-center rounded px-3 py-1.5 text-sm font-medium transition ' . match ($variant) {
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'secondary' => 'border border-brand text-brand-dark hover:bg-brand/10',
        default => 'bg-brand text-white hover:bg-brand-dark',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
