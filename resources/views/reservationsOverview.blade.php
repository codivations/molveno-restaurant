@extends("layouts.main")

@section("title", "reservations")

@section("content")
    <h1>OVERVIEW RESERVATIONS</h1>

    <div>tables reserved: {{ $data->reservedTablesAmount }}</div>
    <div>total high chairs: {{ $data->highChairAmount }}</div>
    <div>total booster seats: {{ $data->boosterSeatAmount }}</div>

    <div class="filters">
        <form action="/reservations" method="POST" class="reservation-filters">
            @csrf
            <label for="from">from</label>
            <input
                type="datetime-local"
                name="from"
                id="from"
                value="{{ $filterData->from ?? "" }}"
            />

            <label for="to">to</label>
            <input
                type="datetime-local"
                name="to"
                id="to"
                value="{{ $filterData->to ?? "" }}"
            />

            <input type="submit" name="filter" value="filter" />
        </form>
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
                    <div>Empty</div>
            @endswitch

            <a href="/reservations/new">new</a>
        </div>
    </div>
@endsection
