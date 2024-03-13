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
