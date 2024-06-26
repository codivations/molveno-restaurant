<form action="/reservations" method="POST">
    @csrf
    <div>
        <label for="service">service</label>
        <select name="service" id="service">
            <option
                value="all"
                {{ ($filterData->service ?? "") == "all" ? "selected " : "" }}
            >
                All
            </option>
            <option
                value="breakfast"
                {{ ($filterData->service ?? "") == "breakfast" ? "selected " : "" }}
            >
                Breakfast
            </option>
            <option
                value="lunch"
                {{ ($filterData->service ?? "") == "lunch" ? "selected " : "" }}
            >
                Lunch
            </option>
            <option
                value="dinner"
                {{ ($filterData->service ?? "") == "dinner" ? "selected " : "" }}
            >
                Dinner
            </option>
        </select>
    </div>

    <div>
        <label for="from">date</label>
        <input
            type="date"
            name="from"
            id="from"
            value="{{ $filterData->date ?? date_time_set(new DateTime(), 0, 00)->format("Y-m-d") }}"
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
            Reset filters
        </a>
    </div>
</form>
