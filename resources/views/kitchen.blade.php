@extends("layouts.main")
@section("title", "kitchen display")
@section("content")
    <div class="topbar"></div>
    <div class="grid grid-flow-row">
        @foreach ($orders as $order)
            <p>{{ $order->id }} {{ $order->status }}</p>
        @endforeach
    </div>
@endsection
