@props([
    "orderItem",
])

<div class="border border-red-400 p-2">
    <div class="flex w-full justify-between">
        <p class="first-letter:uppercase">{{ $orderItem->item->name }}</p>
        <p>{{ $orderItem->item->getprice() }}</p>
    </div>
    <div class="flex w-full justify-between">
        @if ($orderItem->notes)
            <p>Notes</p>
        @else
            <p></p>
        @endif
        @if ($orderItem->dietary_restrictions)
            <p>
                Allergy:
                <span class="order-allergy">&#x2714;</span>
            </p>
        @else
            <p></p>
        @endif
    </div>
    @if ($orderItem->notes)
        <div class="rounded-md border border-black bg-gray-300 p-2">
            {{ $orderItem->notes }}
        </div>
    @endif
</div>
