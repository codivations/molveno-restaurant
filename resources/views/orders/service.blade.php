@extends("layouts.main")

@section("title", "orders: $menu->service")

@section("content")
    <div class="bg-gray-200">
        @include("orders.orderMenu")
        <section class="mx-2 my-2 flex flex-col gap-2">
            @foreach ($menu->items as $item)
                <article
                    class="flex flex-1 justify-between rounded-md border border-black bg-white p-4"
                >
                    <div class="flex w-5/6 flex-wrap justify-between">
                        <h3 class="w-1/2 text-2xl">{{ $item->name }}</h3>
                        <p class="w-1/2">{{ $item->getPrice() }}</p>
                        <p class="w-full">{{ $item->description }}</p>
                    </div>
                    <button type="button" class="">
                        <x-add-circle-icon />
                    </button>
                </article>
            @endforeach
        </section>
    </div>
@endsection
