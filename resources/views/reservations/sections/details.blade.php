<div class="h-full w-full">
    <div
        class="flex h-full flex-col justify-between"
        x-data="{ modalOpen: false }"
    >
        <div class="container m-5 mx-auto w-2/3">
            <div class="text-center text-4xl">
                Reservation for {{ $selectedReservation->name }}
            </div>

            <div>
                <div class="reservation-info">
                    <span>Reservation number:</span>
                    <span>{{ $selectedReservation->id }}</span>
                </div>
                <div class="reservation-info">
                    <span>Date:</span>
                    <span>
                        {{ (new DateTime($selectedReservation->reservation_time))->format("d-m-y") }}
                    </span>
                </div>
                <div class="reservation-info">
                    <span>Time:</span>
                    <span>
                        {{ (new DateTime($selectedReservation->reservation_time))->format("H:i") }}
                    </span>
                </div>
                <div class="reservation-info">
                    <span>Service:</span>
                    <span>
                        {{ $selectedReservation->service }}
                    </span>
                </div>
                <div class="reservation-info">
                    <span>Party size:</span>
                    <span>{{ $selectedReservation->party_size }}</span>
                </div>
                <div class="reservation-info">
                    <span>Table amount:</span>
                    <span>{{ $selectedReservation->table_amount }}</span>
                </div>
                <div class="reservation-info">
                    <span>Seating area:</span>
                    <span>{{ $selectedReservation->seating_area }}</span>
                </div>
                <div class="reservation-info">
                    <span>High chairs:</span>
                    <span>{{ $selectedReservation->high_chair_amount }}</span>
                </div>
                <div class="reservation-info">
                    <span>Booster seats:</span>
                    <span>
                        {{ $selectedReservation->booster_seat_amount }}
                    </span>
                </div>
                <div class="reservation-info">
                    <span>Phone number:</span>
                    <span>{{ $selectedReservation->phone_number }}</span>
                </div>
                <div class="reservation-info">
                    <span>Dietary restrictions:</span>
                    <span>
                        {{ $selectedReservation->dietary_restrictions }}
                    </span>
                </div>
                <div class="notes">
                    <div>Notes:</div>
                    <div
                        class="field rounded-lg border border-solid bg-white p-2 shadow"
                    >
                        {{ $selectedReservation->notes }}
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="button-row">
                <button
                    class="button bg-red-600 font-bold"
                    x-on:click="modalOpen = ! modalOpen"
                >
                    Remove
                </button>

                <div>
                    <a
                        href="{{ route("reservations.editForm", ["id" => $selectedReservation->id]) }}"
                        class="button justify-self-center"
                    >
                        Edit
                    </a>
                </div>
            </div>
            <div class="button-row">
                <a class="button" href="/reservations">Back</a>
            </div>
        </div>

        @error("id")
            <div
                class="modal"
                x-data="{ errorOpen: true }"
                x-show="errorOpen"
            >
                <div class="dialog-box">
                    <div class="dialog-text w-fit text-center">
                        Failed to delete selected reservation! ID invalid!
                    </div>
                    <div class="button-row">
                        <button
                            class="button"
                            x-on:click="errorOpen = ! errorOpen"
                        >
                            Ok
                        </button>
                    </div>
                </div>
            </div>
        @enderror

        <div class="modal" x-show="modalOpen">
            <div class="dialog-box">
                <div class="dialog-text w-fit text-center">
                    Are you certain you want to delete this reservation?
                </div>
                <div class="button-row">
                    <button
                        class="button"
                        x-on:click="modalOpen = ! modalOpen"
                    >
                        Cancel
                    </button>
                    <form
                        method="POST"
                        action="{{ route("reservations.delete", ["id" => $selectedReservation->id]) }}"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="id"
                            value="{{ $selectedReservation->id }}"
                        />
                        <button class="button">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
