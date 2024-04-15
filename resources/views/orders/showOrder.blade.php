@extends("layouts.main")

@section("title", "Show Order")

@section("content")
    <div class="order-grid min-h-screen bg-gray-200 px-2">
        <header class="flex items-center justify-between bg-white px-2">
            <h1 class="text-3xl font-bold underline">
                Table {{ $tableNumber }}
            </h1>
            <div class="flex gap-2">
                <a
                    href="/order/{{ $tableNumber }}/drinks"
                    class="button h-8 w-20"
                >
                    Add
                </a>
                <form method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="h-8 w-20 rounded-full border border-black bg-green-500"
                    >
                        Send
                    </button>
                </form>
            </div>
        </header>
        <section class="flex flex-col">
            @if (session("success"))
                <div
                    class="w-52 border border-black bg-green-500 p-3 text-center"
                >
                    <p>{{ session("success") }}</p>
                </div>
            @endif

            @if (session("order")->items ?? false)
                @foreach (session("order")->items as $item)
                    <article>
                        <div
                            class="mt-2 rounded-md border border-black bg-white p-4"
                        >
                            <div class="flex justify-between">
                                <span class="text-4xl">
                                    {{ $item["item_name"] }}
                                </span>
                                <span>{{ $item["menu_item_id"] }}</span>
                            </div>
                            <div>
                                {{ $item["dietary_restrictions"] ? "Has allergy" : "" }}
                            </div>
                            <div>Notes:</div>
                            <div
                                class="gap-1 rounded-md border border-black bg-gray-300 p-2"
                            >
                                {{ $item["notes"] ?? "" }}
                            </div>
                        </div>
                    </article>
                @endforeach
            @else
                <h2>There are no items selected</h2>
            @endif
        </section>
        <footer class="max-w-full self-end">
            @include("layouts.navbar")
        </footer>
    </div>
@endsection
