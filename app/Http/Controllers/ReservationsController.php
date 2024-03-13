<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;

class ReservationsController extends Controller
{
    public function show()
    {
        return view("reservationForm");
    }

    public function store(Request $request)
    {
        $reservation = new Reservations();
        $reservation->name = $request->name;
        $reservation->party_size = $request->party_size;
        $reservation->table_amount = $request->table_amount;
        $reservation->phone_number = $request->phone_number;
        $reservation->reservation_time = $request->reservation_time;
        $reservation->notes = $request->notes;
        $reservation->seating_area = $request->seating_area;
        $reservation->high_chair_amount = $request->high_chair_amount;
        $reservation->booster_seat_amount = $request->booster_seat_amount;
        $reservation->dietary_restrictions = $request->has(
            "dietary_restrictions"
        );
        $reservation->save();

        return redirect("/reservations")->with(
            "notification",
            "reservation added succesfully"
        );
    }
}
