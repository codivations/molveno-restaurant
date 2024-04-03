@props([
    "active",
    "href",
])

@php
    $shadow = $active ?? false ? "menu-shadow shadow-black" : ""
@endphp

<a
    class="{{ $shadow }} nav-bg text-2xs flex h-16 w-16 flex-shrink-0 flex-col items-center justify-center rounded-md p-2"
    href="{{ $href }}"
>
    {{ $slot }}
</a>
