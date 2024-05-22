<li class="m-3 rounded-lg border border-solid bg-white p-2 shadow">
    <div class="grid grid-cols-4 grid-rows-2">
        <div class="col row-span-2">
            <div class="text-2xl">{{ $reservation->name }}</div>
            <div># {{ $reservation->id }}</div>
        </div>
        <div class="col-span-2 row-span-2">
            <span>
                {{ (new DateTime($reservation->reservation_time))->format("d/m/y - H:i") }}
            </span>

            <div class="">
                <span>Party size:</span>
                <span>{{ $reservation->party_size }}</span>

                @if ($reservation->isSeated())
                    <ul class="inline-list">
                        Seated at:
                        @foreach ($reservation->tables as $table)
                            <li>{{ $table->table_number }}</li>
                        @endforeach
                    </ul>
                @else
                    <div>Not seated</div>
                @endif
            </div>
        </div>
        <div class="col row-span-2 m-auto">
            <a
                href="/reservations/id/{{ $reservation->id }}"
                class="button justify-self-center"
            >
                details
            </a>
        </div>
    </div>
</li>
