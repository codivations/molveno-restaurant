@extends("layouts.main")
@section("title", "kitchen display")
@section("content")
    <div class="topbar"></div>
    <div class="container inline-grid h-full grid-flow-col bg-gray-200">
        @foreach ($orders as $order)
            <div class="m-2 w-52 rounded-lg border border-solid border-black">
                <div
                    class="rounded-lg border border-solid border-black bg-slate-400 p-1"
                >
                    {{ $order->created_at->format("H:i") }}
                    {{ $order->staff_id }}
                    <br />
                    {{ $order->id }}
                    {{ $order->status }}
                </div>

                @foreach ($order->orderedItems as $order_item)
                    @php
                        $food = $order_item->item
                    @endphp

                    <div
                        class="m-1 rounded-lg border border-solid bg-white p-1"
                    >
                        <div>{{ $food->name }}</div>
                        <div>NOTES: {{ $order_item->notes }}</div>
                        <div>{{ $order_item->status }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
