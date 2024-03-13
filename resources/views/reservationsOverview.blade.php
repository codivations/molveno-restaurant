@extends("layouts.main")

@section("title", "reservations")

@section("content")
    <h1>OVERVIEW RESERVATIONS</h1>

    <div>tables reserved: {{ $data->reservedTablesAmount }}</div>
    <div>total high chairs: {{ $data->highChairAmount }}</div>
    <div>total booster seats: {{ $data->boosterSeatAmount }}</div>

    <div class="filters">
        <form action="reservations" method="POST" class="reservation-filters">
            @csrf
            <label for="from">from</label>
            {{ old("from") }}
            {{-- <input type="datetime-local" name="from" id="from" value="{{ old('from')}}"> --}}
            <input
                type="datetime-local"
                name="from"
                id="from"
                value="{{ $filterData->from ?? "" }}"
            />

            <label for="to">from</label>
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
        <ul class="w-180 basis-1/4">
            @foreach ($reservations as $reservation)
                @include("sections.reservationCard")
            @endforeach
        </ul>

        <div class="w-180 basis-3/4">
            @if (session("selectedReservation") != null)
                @php
                    $selectedReservation = session("selectedReservation");
                @endphp

                @include("sections.reservationDetails")
            @else
                <div><span>no reservation selected</span></div>
            @endif
        </div>
    </div>
@endsection
