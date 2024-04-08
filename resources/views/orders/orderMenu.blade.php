<nav
    class="sticky top-0 grid min-w-full grid-flow-col justify-stretch overflow-scroll"
>
    @foreach ($menuNames as $menu)
        <a
            class="{{ $currentService === $menu->service ? "border-b-4 border-b-blue-500" : "border-b border-b-black" }} mb-4 shrink-0 rounded-b-lg border border-black bg-white px-2 py-4 text-center font-semibold first-letter:uppercase"
            href="/order/{{ $tableNumber }}/{{ $menu->service }}"
        >
            {{ $menu->service }}
        </a>
    @endforeach
</nav>
