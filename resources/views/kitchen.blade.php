@extends("layouts.main")
@section("title", "kitchen display")
@section("content")
    <div class="topbar"></div>
    <div class="container inline-grid h-full grid-flow-col bg-gray-400">
        @foreach ($orders as $order)
            <div class="m-3 w-52 rounded-lg border border-solid border-black">
                <div class="rounded-lg bg-slate-400">
                    {{ $order->created_at->format("H:i") }}
                    {{ $order->staff_id }}
                    <br />
                    {{ $order->id }}
                    {{ $order->status }}
                </div>
                {{-- This is not a lightweight solution, but it works --}}
                @foreach ($ordered_items as  $order_item)
                    @if ($order_item->order_id == $order->id)
                        <div class="rounded-lg border border-solid bg-white">
                            {{ $order_item->status }} []
                        </div>
                    @endif()
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
