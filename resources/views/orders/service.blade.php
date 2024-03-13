@extends("layouts.main")

@section("title", "orders: $menu->service")

@section("content")
    @include("orders.orderMenu")
    <section class="flex flex-col gap-2">
        @foreach ($menu->items as $item)
            <article class="flex-1 rounded-md border border-black bg-white p-4">
                <h3 class="text-2xl">{{ $item->name }}</h3>
            </article>
        @endforeach
    </section>
@endsection
