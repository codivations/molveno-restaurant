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

                {{--
                    <span>Tables:</span>
                    <span>{{ $reservation->table_amount }}</span>
                --}}

                @if ($reservation->tables->first() != null)
                    <div>
                        Seated at:
                        {{ $reservation->tables->first()->table_number }}
                    </div>
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
