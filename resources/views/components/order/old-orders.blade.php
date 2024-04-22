@props([
    "allOrders",
])

<h2 class="text-xl">Previous orders:</h2>
<div class="flex flex-col gap-4">
    @foreach ($allOrders as $order)
        <article class="flex flex-col gap-4 border border-black bg-white">
            <h3 class="text-lg font-bold">Order: {{ $loop->index + 1 }}</h3>
            @foreach ($order->orderedItems as $orderItem)
                <x-order.old-order-item :orderItem="$orderItem" />
            @endforeach
        </article>
    @endforeach
</div>
