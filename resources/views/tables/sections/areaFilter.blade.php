<nav class="flex w-full">
    @foreach ($items as $item)
        <a
            class="{{ $currentSelection === $item ? "border-b-4 border-b-blue-500" : "" }} mb-4 border bg-white p-4"
            href="{{ "/tables/" . $route . "/" . ($currentSelection === $item ? "all" : $item) }}"
        >
            {{ $item }}
        </a>
    @endforeach
</nav>
