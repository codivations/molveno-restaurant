@props([
    "active",
    "href",
])

@php
    $shadow = $active ?? false ? "menu-shadow shadow-black" : ""
@endphp

<a
    class="{{ $shadow }} nav-bg flex w-20 flex-col items-center justify-center rounded-md text-xs"
    href="{{ $href }}"
>
    {{ $slot }}
</a>
