@extends("layouts.main")
@vite(["resources/sass/"])
@section("title", "reservations")

@section("content")
    {{-- <h1>OVERVIEW RESERVATIONS</h1> --}}

    <div class="flex flex-row">
        <div class="w-180 m-3 basis-1/4">
            <div class="filters">
                @include("sections.reservations.filters")
            </div>
        </div>
        <div class="m-3 basis-3/4">
            <div>
                Seating area:
                <span class="capitalized">
                    {{ $filterData->seating_area ?? "All" }}
                </span>
            </div>
            <div>tables reserved: {{ $data->reservedTablesAmount }}</div>
            <div>total high chairs: {{ $data->highChairAmount }}</div>
            <div>total booster seats: {{ $data->boosterSeatAmount }}</div>

            <a href="/reservations/new" class="button">new</a>
        </div>
    </div>

    <div class="flex flex-row">
        <ul
            class="w-180 m-2 basis-1/3 overflow-scroll rounded-lg border border-solid bg-slate-300"
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
                    <div></div>
            @endswitch

            {{-- <a href="/reservations/new" class='button'>new</a> --}}
        </div>
    </div>
@endsection
