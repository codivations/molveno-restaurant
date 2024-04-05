<nav class="flex w-full">
    @foreach ($items as $item)
        <a
            class="{{ $currentSelection === $item ? "border-b-4 border-b-blue-500" : "" }} mb-4 border bg-white p-4"
            href="{{ "/tables/" . ($currentSelection === $item ? "all" : $item) . "/" . $route }}"
        >
            {{ $item }}
        </a>
    @endforeach
</nav>
