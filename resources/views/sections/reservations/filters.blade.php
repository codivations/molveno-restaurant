<form action="/reservations" method="POST" class="reservation-filters">
    @csrf
    <div>
        <label for="from">from</label>
        <input
            type="datetime-local"
            name="from"
            id="from"
            value="{{ $filterData->from ?? "" }}"
        />
        <label for="to">to</label>
        <input
            type="datetime-local"
            name="to"
            id="to"
            value="{{ $filterData->to ?? "" }}"
        />
    </div>

    <div>
        <label for="area">seating area</label>
        <select name="area" id="area">
            <option value="all" default>All</option>
            <option value="terrace">Terrace</option>
            <option value="ground floor">Ground floor</option>
            <option value="first floor">First floor</option>
        </select>
    </div>

    <div>
        <input type="submit" name="filter" value="filter" />
    </div>
</form>
