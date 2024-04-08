@extends("layouts.main")

@section("title", "Show Order")

@section("content")
    <div class="flex min-h-screen flex-col justify-between bg-gray-200 px-2">
        <header class="flex items-center justify-between">
            <h1 class="text-3xl underline">Table {{ $tableNumber }}</h1>
            <div class="flex">
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
            @if (session("order") && session("order")->items)
                @foreach (session("order")->items as $item)
                    <article>
                        {{-- <h3>{{ $item["name"]}}</h3> --}}
                        <p>{{ $item["menu_item_id"] }}</p>
                    </article>
                @endforeach
            @else
                <h2>There are no items selected</h2>
            @endif
        </section>
        <footer class="sticky bottom-0 max-w-full">
            @include("layouts.navbar")
        </footer>
    </div>
@endsection
