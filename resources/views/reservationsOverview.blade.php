@extends("layouts.main")
@vite(["resources/sass/"])
@section("title", "reservations")

@section("content")
    <div class="flex flex-row">
        <div class="w-180 filters m-3 basis-1/4">
            @include("sections.reservations.filters")
        </div>
        <div class="m-3 basis-3/4">
            <a href="/reservations/new" class="button">new</a>
        </div>
    </div>

    <div class="flex flex-row">
        <ul
            class="w-180 m-2 basis-1/4 overflow-scroll rounded-lg border border-solid bg-slate-300"
            style="height: 750px"
        >
            @foreach ($reservations as $reservation)
                @include("sections.reservationCard")
            @endforeach
        </ul>

        <div class="m-3 basis-3/4 rounded bg-gray-200 p-2 shadow">
            @switch(session("showDetailWindow"))
                @case("details")
                    @if (session("selectedReservation") != null)
                        @php
                            $selectedReservation = session("selectedReservation");
                        @endphp

                        @include("sections.reservationDetails")
                    @else
                        <div>
                            <span>error: no valid reservation selected</span>
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
@endsection
