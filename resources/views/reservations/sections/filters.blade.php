<form action="/reservations" method="POST">
    @csrf
    <div>
        <label for="from">from</label>
        <input
            type="datetime-local"
            name="from"
            id="from"
            value="{{ $filterData->from ?? date_time_set(new DateTime(), 0, 00)->format("Y-m-d H:i") }}"
        />
    </div>

    <div>
        <label for="to">to</label>
        <input
            type="datetime-local"
            name="to"
            id="to"
            value="{{ $filterData->to ?? date_time_set(new DateTime(), 23, 59)->format("Y-m-d H:i") }}"
        />
    </div>

    <div>
        <label for="area">seating area</label>
        <select name="area" id="area">
            <option
                value="all"
                {{ ($filterData->seating_area ?? "") == \App\Enums\SeatingArea::ALL ? "selected " : "" }}
            >
                All
            </option>
            <option
                value="terrace"
                {{ ($filterData->seating_area ?? "") == \App\Enums\SeatingArea::TERRACE ? "selected " : "" }}
            >
                Terrace
            </option>
            <option
                value="ground floor"
                {{ ($filterData->seating_area ?? "") == \App\Enums\SeatingArea::GROUNDFLOOR ? "selected " : "" }}
            >
                Ground floor
            </option>
            <option
                value="first floor"
                {{ ($filterData->seating_area ?? "") == \App\Enums\SeatingArea::FIRSTFLOOR ? "selected " : "" }}
            >
                First floor
            </option>
        </select>
    </div>

    <div class="filter-buttons">
        <input type="submit" class="button" name="filter" value="filter" />
        <a href="{{ route("reservations.clear") }}" class="button">
            reset filters
        </a>
    </div>
</form>
