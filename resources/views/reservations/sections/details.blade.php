<div
    class="flex h-full flex-col justify-between"
    x-data="{ modalOpen: false }"
>
    <div class="m-2">
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
            <span>Seating area:</span>
            <span>{{ $selectedReservation->seating_area }}</span>
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
    </div>
    <div class="bottom-bar">
        <button
            class="button justify-self-center bg-red-600 font-bold"
            x-on:click="modalOpen = ! modalOpen"
        >
            Remove
        </button>
    </div>

    <div class="modal" x-show="modalOpen">
        <div class="dialog-box">
            <div class="dialog-text w-fit text-center">
                Are you certain you want to delete this reservation?
            </div>
            <div class="button-row">
                <button class="button" x-on:click="modalOpen = ! modalOpen">
                    Cancel
                </button>
                <a
                    href="/reservations/delete/id/{{ $selectedReservation->id }}"
                    class="button block"
                >
                    Remove
                </a>
            </div>
        </div>
    </div>
</div>
