@csrf
<div class="form-item">
    <label for="name" class="form-label">Name:</label>
    <input
        type="text"
        id="name"
        name="name"
        class="form-input"
        value="{{ $selectedReservation->name ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="party_size" class="form-label">Party size:</label>
    <input
        type="number"
        min="1"
        id="party_size"
        name="party_size"
        class="form-input"
        value="{{ $selectedReservation->party_size ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="table_amount" class="form-label">Table amount:</label>
    <input
        type="number"
        min="1"
        id="table_amount"
        name="table_amount"
        class="form-input"
        value="{{ $selectedReservation->table_amount ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="phone_number" class="form-label">Phone number:</label>
    <input
        type="tel"
        id="phone_number"
        name="phone_number"
        class="form-input"
        value="{{ $selectedReservation->phone_number ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="reservation_time" class="form-label">Date and time:</label>
    <input
        type="datetime-local"
        id="reservation_time"
        name="reservation_time"
        class="form-input"
        value="{{ $selectedReservation->reservation_time ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="seating_area" class="form-label">Select area:</label>
    <select name="seating_area" id="seating_area" class="form-input">
        <option
            value="ground floor"
            @selected($selectedReservation->seating_area ?? "" == "ground floor")
        >
            ground floor
        </option>
        <option
            value="first floor"
            @selected($selectedReservation->seating_area ?? "" == "first floor")
        >
            first floor
        </option>
        <option
            value="terrace"
            @selected($selectedReservation->seating_area ?? "" == "terrace")
        >
            terrace
        </option>
    </select>
</div>
<div class="form-item">
    <label for="high_chair_amount" class="form-label">High chair amount:</label>
    <input
        class="form-input"
        type="number"
        min="0"
        id="high_chair_amount"
        name="high_chair_amount"
        value="{{ $selectedReservation->high_chair_amount ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="booster_seat_amount" class="form-label">
        Booster seat amount:
    </label>
    <input
        class="form-input"
        type="number"
        min="0"
        id="booster_seat_amount"
        name="booster_seat_amount"
        value="{{ $selectedReservation->booster_seat_amount ?? "" }}"
    />
</div>
<div class="form-item">
    <label for="dietary_restrictions" class="form-label">
        Dietary restrictions
    </label>
    <input
        class=""
        type="checkbox"
        id="dietary_restrictions"
        name="dietary_restrictions"
        value="1"
        @checked($selectedReservation->dietary_restrictions ?? "0")
    />
</div>
<div class="form-item">
    <label for="notes" class="form-label">Notes:</label>
    <textarea id="notes" name="notes" class="h-20rem form-input">
{{ $selectedReservation->notes ?? "" }}</textarea
    >
</div>
