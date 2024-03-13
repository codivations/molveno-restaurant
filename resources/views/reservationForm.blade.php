@extends("layouts.main")

@section("title", "test2")

@section("content")
    <h1 class="text-blue-600">New reservation</h1>
    <form action="/reservations/create" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" />
        </div>
        <div>
            <label for="party_size">Party size:</label>
            <input type="number" min="1" id="party_size" name="party_size" />
        </div>
        <div>
            <label for="table_amount">Table amount:</label>
            <input
                type="number"
                min="1"
                id="table_amount"
                name="table_amount"
            />
        </div>
        <div>
            <label for="phone_number">Phone number:</label>
            <input type="tel" id="phone_number" name="phone_number" />
        </div>
        <div>
            <label for="reservation_time">Date and time:</label>
            <input
                type="datetime-local"
                id="reservation_time"
                name="reservation_time"
            />
        </div>
        <div>
            <label for="notes">Notes:</label>
            <input type="text" id="notes" name="notes" />
        </div>
        <div>
            <label for="seating_area">Select area:</label>
            <select name="seating_area" id="seating_area">
                <option value="ground floor">ground floor</option>
                <option value="first floor">first floor</option>
                <option value="terrace">terrace</option>
            </select>
        </div>
        <div>
            <label for="high_chair_amount">High chair amount:</label>
            <input
                type="number"
                min="0"
                id="high_chair_amount"
                name="high_chair_amount"
            />
        </div>
        <div>
            <label for="booster_seat_amount">Booster seat amount:</label>
            <input
                type="number"
                min="0"
                id="booster_seat_amount"
                name="booster_seat_amount"
            />
        </div>
        <div>
            <label for="dietary_restrictions">Dietary restrictions</label>
            <input
                type="checkbox"
                id="dietary_restrictions"
                name="dietary_restrictions"
                value="1"
            />
        </div>
        <div>
            <input type="submit" value="confirm" class="rounded-full" />
        </div>
    </form>
@endsection
