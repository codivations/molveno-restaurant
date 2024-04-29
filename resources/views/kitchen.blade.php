@extends("layouts.main")
@section("title", "kitchen display")
@section("content")
    <div class="flex max-h-screen min-h-screen flex-col">
        <div class="topbar">
            <x-burger-menu />
        </div>
        <div
            id="order-overview"
            class="max-w-100 flex-flow-col flex max-h-dvh flex-auto flex-shrink-0 overflow-auto bg-slate-400"
        >
            @foreach ($orders as $order)
                <div
                    class="min-h-content m-1 h-fit max-h-[100vh] min-w-72 rounded-lg border border-solid border-black bg-gray-600"
                >
                    <div
                        class="grid grid-cols-2 grid-rows-2 justify-between gap-1 rounded-lg border-2 border-solid border-black bg-teal-300 bg-opacity-40 p-2 font-bold uppercase text-white"
                    >
                        <div>{{ $order->created_at->format("H:i") }}</div>
                        <div>{{ $order->user->name }}</div>
                        <div>
                            Table {{ $order->table()->table_number ?? "none" }}
                        </div>
                        <div class="align flex gap-9">
                            {{ $order->status }}
                            @if ($order->status == "ready")
                                <a
                                    href="/kitchen/close/id/{{ $order->id }}"
                                    class="button h-6 w-6 rounded-sm p-0 align-baseline"
                                >
                                    &#x2714;
                                </a>
                            @endif
                        </div>
                    </div>

                    <ul class="flex h-fit max-h-[85vh] flex-col overflow-auto">
                        @foreach ($order->orderedItems as $order_item)
                            @php
                                $item = $order_item->item
                            @endphp

                            <li>
                                <div
                                    class="m-1 flex flex-col rounded-lg border border-solid bg-white p-1"
                                >
                                    <div class="font-bold uppercase">
                                        {{ $item->name }}
                                    </div>
                                    <div class="">
                                        @if ($order_item->dietary_restrictions == "1")
                                            <p
                                                class="font-semibold italic text-red-600"
                                            >
                                                Allergy warning
                                            </p>
                                        @endif

                                        NOTES: {{ $order_item->notes }}
                                    </div>
                                    @php
                                        $statusClass = str_replace(" ", "", $order_item->status);
                                    @endphp

                                    {{-- For some reason this status dependant class didn't want to listen. --}}
                                    <div class="m-1 flex self-end p-1">
                                        <a
                                            href="/kitchen/progress/id/{{ $order_item->id }}"
                                            class="{{ $statusClass }} button flex w-fit rounded-md p-1"
                                        >
                                            {{ $order_item->status }}
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        let element = document.getElementById('order-overview');

        let scrollX = localStorage.getItem('scrollX');
        let scrollY = localStorage.getItem('scrollY');
        if (scrollX && scrollY) {
            element.scrollTo(scrollX, scrollY);
        }

        window.onbeforeunload = function () {
            localStorage.setItem('scrollX', element.scrollLeft);
            localStorage.setItem('scrollY', element.scrollTop);
        };

        let refreshTimeInSeconds = 30;
        setTimeout(function () {
            window.location.reload();
        }, refreshTimeInSeconds * 1000);
    </script>
@endsection
