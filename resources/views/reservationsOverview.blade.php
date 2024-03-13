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
                <li class="m-3 w-96 rounded bg-blue-200 p-2 shadow">
                    <div class="flex flex-row">
                        <div class="basis-4/5">
                            <div>
                                <span>{{ $reservation->id }}</span>
                                <span>{{ $reservation->name }}</span>
                            </div>
                            <div>
                                <span>Date:</span>
                                <span>
                                    {{ (new DateTime($reservation->reservation_time))->format("d-m-y") }}
                                </span>
                            </div>
                            <div>
                                <span>Time:</span>
                                <span>
                                    {{ (new DateTime($reservation->reservation_time))->format("H:i") }}
                                </span>
                            </div>
                            <div>
                                <span>Party size:</span>
                                <span>{{ $reservation->party_size }}</span>
                            </div>
                            <div>
                                <span>Tables:</span>
                                <span>{{ $reservation->table_amount }}</span>
                            </div>
                            {{--
                                <div><span>high chairs:</span> <span>{{ $reservation->high_chair_amount }}</span></div>
                                <div><span>booster seats:</span> <span>{{ $reservation->booster_seat_amount }}</span></div>
                                <div><span>Phone number:</span> <span>{{ $reservation->phone_number }}</span></div>
                                <div><span>Dietary restrictions:</span> <span>{{ $reservation->dietary_restrictions }}</span></div>
                                <div><div>Notes:</div> <div>{{ $reservation->notes }}</div></div>
                            --}}
                        </div>
                        <div class="basis-1/5">
                            <form
                                action="/reservations/{{ $reservation->id }}"
                                method="POST"
                                class="reservation-details"
                            >
                                @csrf
                                <input
                                    type="submit"
                                    name="details"
                                    value="details"
                                />
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="w-180 basis-3/4">
            @if (session("selectedReservation") != null)
                @php
                    $selectedReservation = session("selectedReservation");
                @endphp

                <div>
                    <span>{{ $selectedReservation->id }}</span>
                    <span>{{ $selectedReservation->name }}</span>
                </div>
                <div>
                    <span>Date:</span>
                    <span>
                        {{ (new DateTime($selectedReservation->reservation_time))->format("d-m-y") }}
                    </span>
                </div>
                <div>
                    <span>Time:</span>
                    <span>
                        {{ (new DateTime($selectedReservation->reservation_time))->format("H:i") }}
                    </span>
                </div>
                <div>
                    <span>Party size:</span>
                    <span>{{ $selectedReservation->party_size }}</span>
                </div>
                <div>
                    <span>Tables:</span>
                    <span>{{ $selectedReservation->table_amount }}</span>
                </div>
                <div>
                    <span>high chairs:</span>
                    <span>{{ $selectedReservation->high_chair_amount }}</span>
                </div>
                <div>
                    <span>booster seats:</span>
                    <span>
                        {{ $selectedReservation->booster_seat_amount }}
                    </span>
                </div>
                <div>
                    <span>Phone number:</span>
                    <span>{{ $selectedReservation->phone_number }}</span>
                </div>
                <div>
                    <span>Dietary restrictions:</span>
                    <span>
                        {{ $selectedReservation->dietary_restrictions }}
                    </span>
                </div>
                <div>
                    <div>Notes:</div>
                    <div>{{ $selectedReservation->notes }}</div>
                </div>
            @else
                <div><span>no reservation selected</span></div>
            @endif
        </div>
    </div>
@endsection
