<nav class="flex w-full">
    @foreach ($menuNames as $menu)
        <a
            class="{{ $currentService === $menu->service ? "border-b-4 border-b-blue-500" : "" }} mb-4 border p-4"
            href="/order/{{ $tableNumber }}/{{ $menu->service }}"
        >
            {{ $menu->service }}
        </a>
    @endforeach
</nav>
