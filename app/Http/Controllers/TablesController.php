<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Order;
use App\Models\Table;
use App\Models\Reservations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TablesController extends Controller
{
    public function show(string $area = "all", string $seated = "all"): View
    {
        $areaSelected = $area;
        $seatedSelected = $seated;

        $query = Table::orderBy("id");
        if ($areaSelected != "all") {
            //dd($areaSelected);
            $query = $query->where("seating_area", $areaSelected);
        }

        $collection = $query->get();

        if ($seatedSelected == "available") {
            $collection = $collection->filter(function ($value, $key) {
                if (!$value["seated_reservation"]) {
                    return $value;
                }
            });
        } elseif ($seatedSelected == "occupied") {
            $collection = $collection->filter(function ($value, $key) {
                if ($value["seated_reservation"]) {
                    return $value;
                }
            });
        }

        $tables = $collection;

        $reservations = $this->getCurrentReservations();
        //dd($reservations);

        $previousOrders = $this->getPreviousOrders($tables);

        return view(
            "tables.index",
            compact([
                "tables",
                "areaSelected",
                "seatedSelected",
                "reservations",
            ])
        );
    }

    public function seat(Request $request)
    {
        $table = Table::find($request->table);
        $reservation = Reservations::find($request->reservation);
        if ($table == null || $reservation == null) {
            return back();
        }
        $table->seated_reservation = $request->reservation;
        $table->save();

        return back();
    }

    public function unseat(Request $request)
    {
        $table = Table::find($request->table);
        if ($table == null) {
            return back();
        }
        $table->seated_reservation = null;
        $table->save();

        session("orders")->items ?? false;

        return back();
    }

    private function getPreviousOrders($tables)
    {
        $previousOrders = [];
        foreach ($tables as $table) {
            $orders = Order::where(
                "reservation_id",
                $table->seated_reservation
            )->get();

            return $orders;
        }

        return $previousOrders;
    }

    private function getCurrentReservations(): Collection
    {
        $currentDay = new DateTime();

        $query = Reservations::orderBy("name")->whereDate(
            "reservation_time",
            "=",
            date("Y-m-d")
        );
        $collection = $query->get();
        return $collection;
    }

    // private function getFilteredReservations(
    //     SeatingArea $seatingArea,
    //     DateTime $from,
    //     DateTime $to
    // ): Collection {
    //     $reservation = Reservations::orderBy("reservation_time")->whereBetween(
    //         "reservation_time",
    //         [$from, $to]
    //     );

    //     if ($seatingArea != SeatingArea::ALL) {
    //         $reservation->where("seating_area", $seatingArea);
    //     }

    //     return $reservation->get();
    // }
}
