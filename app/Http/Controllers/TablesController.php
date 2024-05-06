<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
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

    public function seat(Request $request): RedirectResponse
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

    public function unseat(Request $request): RedirectResponse
    {
        $table = Table::find($request->table);
        if ($table == null) {
            return back();
        }
        $table->unseatReservation();

        return back();
    }

    private function getCurrentReservations(): Collection
    {
        $currentDay = date("Y-m-d");

        $query = Reservations::orderBy("name")->whereDate(
            "reservation_time",
            "=",
            $currentDay
        );
        $collection = $query->get();

        return $collection;
    }
}
