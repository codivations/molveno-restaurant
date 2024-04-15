@extends("layouts.main")

@section("title", "Show Order")

@section("content")
    <div class="order-grid">
        <header
            class="sticky top-0 flex items-center justify-between rounded-b-lg border-x border-b border-black bg-white p-4"
        >
            <h1 class="text-3xl font-bold underline">
                Table {{ $tableNumber }}
            </h1>
            <div class="flex gap-2 text-sm font-bold">
                <a
                    href="/order/{{ $tableNumber }}/drinks"
                    class="button h-8 w-16"
                >
                    Add
                </a>
                <form method="POST">
                    @csrf
                    <button type="submit" class="button h-8 w-16 bg-green-500">
                        Send
                    </button>
                </form>
            </div>
        </header>
        <section class="flex flex-col gap-3">
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
                            class="rounded-md border border-black bg-white p-4"
                        >
                            <div class="flex justify-between">
                                <h2
                                    class="text-2xl font-bold first-letter:capitalize"
                                >
                                    {{ $item["item_name"] }}
                                </h2>
                                <p>
                                    {{ $item["price"] }}
                                </p>
                            </div>
                            <div>
                                {{ $item["dietary_restrictions"] ? "Has allergy" : "" }}
                                {{ $item["dietary_restrictions"] ? "Has allergy" : "" }}
                            </div>
                            @if ($item["notes"])
                                <div>Notes:</div>
                                <div
                                    class="gap-1 rounded-md border border-black bg-gray-300 p-2"
                                >
                                    {{ $item["notes"] }}
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            @else
                <h2>There are no items selected</h2>
            @endif
        </section>
        <footer class="bottom-nav">
            @include("layouts.navbar")
        </footer>
    </div>
@endsection
