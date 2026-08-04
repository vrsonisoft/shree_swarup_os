@props([
    'setting' => null,
])

@php
    $imgClass = $attributes->get('class', 'h-8 w-auto');
@endphp

<img src="{{ asset('img/logo.png') }}" alt="ShreeSwarupOS Logo" {{ $attributes->class([$imgClass, 'object-contain shrink-0 rounded-md']) }} style="max-height:44px; border-radius:6px;" />
