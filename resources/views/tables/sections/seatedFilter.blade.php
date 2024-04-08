<div class="grid w-full grid-flow-col justify-stretch">
    @foreach ($items as $item)
        <a
            class="{{ $currentSelection === $item ? "border-b-4 border-b-blue-500" : "" }} mb-4 shrink-0 rounded-b-lg border border-black bg-white px-2 pb-4 pt-5 text-center font-semibold first-letter:uppercase"
            style="margin-top: -8px"
            href="{{ "/tables/" . $route . "/" . ($currentSelection === $item ? "all" : $item) }}"
        >
            {{ $item }}
        </a>
    @endforeach
</div>
