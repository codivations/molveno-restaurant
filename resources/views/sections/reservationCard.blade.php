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
        </div>
        <div class="basis-1/5">
            <a href="/reservations/{{ $reservation->id }}" class="button">
                details
            </a>
        </div>
    </div>
</li>
