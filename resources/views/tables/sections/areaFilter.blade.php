<div class="grid w-full grid-flow-col justify-stretch">
    @foreach ($items as $item)
        <a
            class="{{ $currentSelection === $item ? "border-b-4 border-b-blue-500" : "" }} z-10 mb-0 shrink-0 rounded-b-lg border border-black bg-white px-2 py-4 text-center font-semibold first-letter:uppercase"
            href="{{ "/tables/" . ($currentSelection === $item ? "all" : $item) . "/" . $route }}"
        >
            {{ $item }}
        </a>
    @endforeach
</div>
