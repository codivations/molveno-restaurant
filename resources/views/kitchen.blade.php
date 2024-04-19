@extends("layouts.main")
{{-- @include("sections.kitchen.statusButton") --}}
@section("title", "kitchen display")
@section("content")
    {{--
        TODO
        Todo/inprogress/done checks
        Make sum total overview
        Figure out how done orders get gone
        Allow multiples of one item in an order
    --}}
    <div class="flex max-h-screen min-h-screen flex-col">
        <div class="topbar"></div>
        <div
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
                        {{-- <div>{{ $order->staff_id }}</div> --}}
                        <div>{{ $order->user->name }}</div>
                        {{-- <div>{{ $order->id }}</div> --}}
                        <div>
                            Table {{ $order->table()->table_number ?? "none" }}
                        </div>
                        <div class="flex gap-9">
                            {{ $order->status }}
                            @if ($order->status == "ready")
                                <a
                                    href="/kitchen/close/id/{{ $order->id }}"
                                    class="button m-0 h-6 w-6 rounded-sm p-0"
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
                                        {{-- This is nasty, needs work --}}
                                        @if ($order_item->dietary_restrictions == "1")
                                            <p>Allergy warning</p>
                                        @endif

                                        NOTES: {{ $order_item->notes }}
                                    </div>

                                    <div class="m-2 flex self-end p-2">
                                        <a
                                            href="/kitchen/progress/id/{{ $order_item->id }}"
                                            class="button m-0 h-6 w-6 rounded-sm p-0"
                                        >
                                            &#x2714;
                                        </a>
                                    </div>
                                    <div>{{ $order_item->status }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection
