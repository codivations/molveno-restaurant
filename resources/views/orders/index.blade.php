@extends("layouts.main")

@section("title", "view menu")

@section("content")
    <main class="min-h-screen bg-gray-300 p-4 text-black">
        <div class="flex flex-row justify-between gap-4">
            @foreach ($menu as $section)
                <section class="flex-1">
                    <button
                        class="m-2 rounded-md border border-black bg-white px-4 py-3"
                    >
                        {{ $section->service }}
                    </button>
                    <div class="flex flex-col gap-2">
                        @foreach ($section->items as $item)
                            <article
                                class="flex-1 rounded-md border border-black bg-white p-4"
                            >
                                <h3 class="text-2xl">{{ $item->name }}</h3>
                                <p>{{ $item->getPrice() }}</p>
                                <p>{{ $item->description }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </main>
@endsection
