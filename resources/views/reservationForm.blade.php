@extends("layouts.main")

@section("title", "test2")

@section("content")
    <h1 class="text-blue-600">New reservation</h1>
    <form action="/reservations/create" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" />

        <label for="party_size">Party size:</label>
        <input type="number" min="1" id="party_size" name="party_size" />

        <label for="table_amount">Table amount:</label>
        <input type="number" min="1" id="table_amount" name="table_amount" />

        <label for="phone_number">Phone number:</label>
        <input type="tel" id="phone_number" name="phone_number" />

        <label for="reservation_time">Date and time:</label>
        <input
            type="datetime-local"
            id="reservation_time"
            name="reservation_time"
        />

        <label for="notes">Notes:</label>
        <input type="text" id="notes" name="notes" />

        <label for="seating_area">Select area:</label>
        <select name="seating_area" id="seating_area">
            <option value="ground_floor">ground floor</option>
            <option value="first_floor">first floor</option>
            <option value="terrace">terrace</option>
        </select>

        <label for="high_chair_amount">High chair amount:</label>
        <input
            type="number"
            min="0"
            id="high_chair_amount"
            name="high_chair_amount"
        />

        <label for="booster_seat_amount">Booster seat amount:</label>
        <input
            type="number"
            min="0"
            id="booster_seat_amount"
            name="booster_seat_amount"
        />

        <label for="dietary_restrictions">Dietary restrictions</label>
        <input
            type="checkbox"
            id="dietary_restrictions"
            name="dietary_restrictions"
            value="1"
        />

        <input type="submit" value="confirm" />
    </form>
@endsection
