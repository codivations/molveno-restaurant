@csrf
<div class="form-item">
    <label for="name" class="form-label">Name:</label>
    <div>
        <input
            type="text"
            id="name"
            name="name"
            class="form-input"
            value="{{ old("name") ?? ($selectedReservation->name ?? "") }}"
        />
        @error("name")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="party_size" class="form-label">Party size:</label>
    <div>
        <input
            type="number"
            min="1"
            id="party_size"
            name="party_size"
            class="form-input"
            value="{{ old("party_size") ?? ($selectedReservation->party_size ?? "") }}"
        />
        @error("party_size")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="table_amount" class="form-label">Table amount:</label>
    <div>
        <input
            type="number"
            min="1"
            id="table_amount"
            name="table_amount"
            class="form-input"
            value="{{ old("table_amount") ?? ($selectedReservation->table_amount ?? "") }}"
        />
        @error("table_amount")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="phone_number" class="form-label">Phone number:</label>
    <div>
        <input
            type="tel"
            id="phone_number"
            name="phone_number"
            class="form-input"
            value="{{ old("phone_number") ?? ($selectedReservation->phone_number ?? "") }}"
        />
        @error("phone_number")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="reservation_time" class="form-label">Date and time:</label>
    <div>
        <input
            type="datetime-local"
            id="reservation_time"
            name="reservation_time"
            class="form-input"
            value="{{ old("reservation_time") ?? ($selectedReservation->reservation_time ?? "") }}"
        />
        @error("reservation_time")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="seating_area" class="form-label">Select area:</label>
    <div>
        <select name="seating_area" id="seating_area" class="form-input">
            <option
                value="ground floor"
                @selected((old("seating_area") ?? ($selectedReservation->seating_area ?? "")) == "ground floor")
            >
                ground floor
            </option>
            <option
                value="first floor"
                @selected((old("seating_area") ?? ($selectedReservation->seating_area ?? "")) == "first floor")
            >
                first floor
            </option>
            <option
                value="terrace"
                @selected((old("seating_area") ?? ($selectedReservation->seating_area ?? "")) == "terrace")
            >
                terrace
            </option>
        </select>
        @error("seating_area")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="high_chair_amount" class="form-label">High chair amount:</label>
    <div>
        <input
            class="form-input"
            type="number"
            min="0"
            id="high_chair_amount"
            name="high_chair_amount"
            value="{{ old("high_chair_amount") ?? ($selectedReservation->high_chair_amount ?? "") }}"
        />
        @error("high_chair_amount")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="booster_seat_amount" class="form-label">
        Booster seat amount:
    </label>
    <div>
        <input
            class="form-input"
            type="number"
            min="0"
            id="booster_seat_amount"
            name="booster_seat_amount"
            value="{{ old("booster_seat_amount") ?? ($selectedReservation->booster_seat_amount ?? "") }}"
        />
        @error("booster_seat_amount")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="dietary_restrictions" class="form-label">
        Dietary restrictions
    </label>
    <div>
        <input
            class=""
            type="checkbox"
            id="dietary_restrictions"
            name="dietary_restrictions"
            value="1"
            @checked(old("dietary_restrictions") ?? ($selectedReservation->dietary_restrictions ?? "0"))
        />
        @error("dietary_restrictions")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-item">
    <label for="notes" class="form-label">Notes:</label>
    <div>
        <textarea id="notes" name="notes" class="h-20rem form-input">
{{ old("notes") ?? ($selectedReservation->notes ?? "") }}</textarea
        >
        @error("notes")
            <div class="validation-alert">{{ $message }}</div>
        @enderror
    </div>
</div>
