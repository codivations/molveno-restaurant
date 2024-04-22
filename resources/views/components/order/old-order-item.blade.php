@props([
    "orderItem",
])

<div class="border border-red-400 p-4">
    <div class="flex w-1/2 justify-between border border-red-500 p-3">
        <p class="first-letter:uppercase">{{ $orderItem->item->name }}</p>
        <p>{{ $orderItem->item->getprice() }}</p>
    </div>
    @if ($orderItem->notes)
        <p>Notes</p>
        <div class="rounded-md border border-black bg-gray-300 p-2">
            {{ $orderItem->notes }}
        </div>
    @endif
</div>
