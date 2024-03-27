@props([
    "active",
    "href",
])

@php
    $shadow = $active ?? false ? "shadow-md" : ""
@endphp

<a
    class="{{ $shadow }} nav-bg flex w-20 flex-wrap justify-center rounded-md text-xs"
    href="{{ $href }}"
>
    {{ $slot }}
</a>
