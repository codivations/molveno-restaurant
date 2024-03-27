@extends("layouts.main")
@vite(["resources/sass/"])
@section("title", "reservations")

@section("content")
    <div class="bg-gray-600" x-data="{ open: false }">
        <div class="topbar flex flex-row justify-between">
            <button class="button" x-on:click="open = ! open">
                Filters
            </button>
            <a href="/reservations/new" class="button">new</a>
        </div>
        <div class="flex flex-row p-5">
            <div class="basis-1/3 p-2">
                <div class="filters" x-show="open">
                    @include("sections.reservations.filters")
                </div>
                <ul
                    class="w-180 overflow-scroll rounded-lg border border-solid bg-slate-300"
                    style="height: 775px"
                >
                    @foreach ($reservations as $reservation)
                        @include("sections.reservationCard")
                    @endforeach
                </ul>
            </div>
            <div class="m-3 basis-2/3 rounded bg-gray-200 p-2 shadow">
                @switch(session("showDetailWindow"))
                    @case("details")
                        @if (session("selectedReservation") != null)
                            @php
                                $selectedReservation = session("selectedReservation");
                            @endphp

                            @include("sections.reservationDetails")
                        @else
                            <div>
                                <span>
                                    error: no valid reservation selected
                                </span>
                            </div>
                        @endif

                        @break
                    @case("new form")
                        @include("sections.addReservationForm")

                        @break
                    @default
                        <div>
                            @include("sections.reservations.capacityInfo")
                        </div>
                @endswitch
            </div>
        </div>
    </div>
@endsection
