@extends("layouts.main")

@section("title", "Show Order")

@section("content")
    <div class="order-grid">
        <x-order.header :tableNumber="$tableNumber" />
        <section class="flex flex-col gap-3" x-data="{ edit_open: 'false' }">
            @if (session("success"))
                <div
                    class="w-52 border border-black bg-green-500 p-3 text-center"
                >
                    <p>{{ session("success") }}</p>
                </div>
            @endif

            @if (session("order")->items ?? false)
                <x-order.current-order :tableNumber="$tableNumber" />
            @else
                <h2 class="text-xl">There are no items selected</h2>
            @endif

            @if ($previousOrders[0] ?? false)
                <x-order.old-orders
                    :allOrders="$previousOrders"
                    :totalPrice="$totalPrice"
                />
            @endif
        </section>
        <footer class="bottom-nav">
            @include("layouts.navbar")
        </footer>
    </div>
@endsection
