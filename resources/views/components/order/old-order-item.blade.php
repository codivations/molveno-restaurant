@props([
    "orderItem",
])

<div class="flex flex-col gap-2 p-2" x-data="{ open: false }">
    <div class="flex w-full justify-between">
        <p class="first-letter:uppercase">{{ $orderItem->item->name }}</p>
        <p>{{ $orderItem->item->getprice() }}</p>
    </div>
    <div class="flex w-full justify-between">
        <div>
            @if ($orderItem->notes)
                <button
                    type="button"
                    class="rounded-md border p-1"
                    @click="open = ! open"
                >
                    Notes
                </button>
            @endif
        </div>
        <p>
            @if ($orderItem->dietary_restrictions)
                Allergy:
                <span class="order-allergy">&#x2714;</span>
            @endif
        </p>
    </div>
    @if ($orderItem->notes)
        <div
            class="rounded-md border border-black bg-gray-300 p-2"
            x-show="open"
            @click.outside="open = false"
        >
            {{ $orderItem->notes }}
        </div>
    @endif
</div>
