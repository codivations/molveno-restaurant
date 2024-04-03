@extends("layouts.main")
@section("title", "kitchen display")
@section("content")
    {{--
        TODO
        Todo/inprogress/done checks
        Have order top level sticky as well
        Make sum total overview
        Figure out how done orders get gone
        Give it table number instead of order ID
        Allow multiples of one item in an order
    --}}

    <div class="h-full bg-slate-400">
        <div class="topbar"></div>
        <div
            class="overview flex-flow-col inline-flex flex-shrink-0 overflow-auto"
        >
            @foreach ($orders as $order)
                <div
                    class="m-1 h-min min-w-72 rounded-lg border border-solid border-black bg-gray-600"
                >
                    <div
                        class="grid grid-cols-2 grid-rows-2 justify-between gap-1 rounded-lg border border-solid border-black bg-teal-300 bg-opacity-40 p-2 font-bold uppercase text-white"
                    >
                        <div>{{ $order->created_at->format("H:i") }}</div>
                        <div>{{ $order->staff_id }}</div>
                        <div>{{ $order->id }}</div>
                        <div>{{ $order->status }}</div>
                    </div>

                    @foreach ($order->orderedItems as $order_item)
                        @php
                            $food = $order_item->item
                        @endphp

                        <div
                            class="m-1 rounded-lg border border-solid bg-white p-1"
                        >
                            <div class="font-bold uppercase">
                                {{ $food->name }}
                            </div>
                            <div>NOTES: {{ $order_item->notes }}</div>
                            <div>{{ $order_item->status }}</div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
