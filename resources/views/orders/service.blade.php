@extends("layouts.main")

@section("title", "orders: $menu->service")

@section("content")
    <div class="bg-gray-200">
        @include("orders.orderMenu")
        @if (session("message"))
            <p class="mx-4">{{ session("message") }}</p>
        @endif

        <section
            class="mx-2 my-2 flex flex-col"
            x-data="{ item_open: null }"
        >
            @foreach ($menu->items as $item)
                <article
                    class="mt-4 flex flex-1 justify-between rounded-md border border-black bg-white p-4"
                >
                    <div class="flex w-5/6 flex-wrap justify-between">
                        <h3 class="w-1/2 text-2xl">{{ $item->name }}</h3>
                        <p class="w-1/2">{{ $item->getPrice() }}</p>
                        <p class="w-full">{{ $item->description }}</p>
                    </div>
                    <button
                        type="button"
                        class=""
                        @click="item_open = item_open == {{ $item->id }} ? null : {{ $item->id }} "
                    >
                        <x-add-circle-icon />
                    </button>
                </article>
                <form
                    x-show="item_open == {{ $item->id }}"
                    action="/order/{{ $tableNumber }}/{{ $menu->service }}"
                    method="POST"
                    class="flex flex-col gap-2 border border-t-0 border-black bg-gray-300 p-4"
                >
                    @csrf
                    <input
                        type="hidden"
                        name="menu_item_id"
                        value="{{ $item->id }}"
                    />
                    <input
                        type="hidden"
                        name="item_name"
                        value="{{ $item->name }}"
                    />
                    <label class="">
                        <input type="checkbox" name="dietary_restrictions" />
                        Allergies
                    </label>
                    <div class="flex gap-2">
                        <textarea
                            name="notes"
                            placeholder="Special notes"
                        ></textarea>
                        <button
                            type="submit"
                            class="h-10 rounded-full border border-black bg-green-500 p-2"
                        >
                            submit
                        </button>
                    </div>
                </form>
            @endforeach
        </section>
    </div>
@endsection
