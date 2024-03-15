<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

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

    public function showReservation(string $id)
    {
        session(["showDetailWindow" => "details"]);
        $selectedReservation = $this->getReservationById($id);
        session(["selectedReservation" => $selectedReservation]);

        return $this->showOverview();
    }

    public function showFilteredOverview(Request $request)
    {
        if ($this->filterValidationFails()) {
            //TODO: add proper validation and pass error messages
            //dd("filter not properly set");
            return $this->showUnfilteredOverview();
        }

        session(["reservationViewFiltered" => true]);
        $filterData = $this->getFilterDataObj($request);
        session(["filterData" => $filterData]);

        return $this->showOverview();
    }

    public function showUnfilteredOverview()
    {
        session(["reservationViewFiltered" => false]);

        return $this->showOverview();
    }

    public function showOverview()
    {
        if (session("reservationViewFiltered") == true) {
            $reservations = $this->getReservationsInBetweenDateTimes(
                new DateTime(session("filterData")->from),
                new DateTime(session("filterData")->to)
            );
            $filterData = session("filterData");
        } else {
            $reservations = $this->getAllReservations();
            $filterData = null;
        }

        $data = $this->getOverviewDataObj($reservations);

        return view(
            "reservationsOverview",
            compact(["data", "filterData", "reservations"])
        );
    }

    public function showForm()
    {
        session(["showDetailWindow" => "new form"]);

        return $this->showOverview();
    }

    #region get reservations
    private function getAllReservations(
        string $orderedBy = "reservation_time"
    ): Collection {
        return Reservations::orderBy($orderedBy)->get();
    }

    private function getReservationsInBetweenDateTimes(
        DateTime $from,
        DateTime $to
    ): Collection {
        return Reservations::orderBy("reservation_time")
            ->whereBetween("reservation_time", [$from, $to])
            ->get();
    }

    private function getReservationById(string $id)
    {
        return Reservations::where("id", $id)->first();
    }
    #endregion

    private function getFilterDataObj(Request $request): object
    {
        $filterData = new stdClass();

        $filterData->from = $request->from;
        $filterData->to = $request->to;

        return $filterData;
    }

    private function getOverviewDataObj(Collection $collection): object
    {
        $data = new stdClass();
        $data->highChairAmount = $this->sumColumn(
            $collection,
            "high_chair_amount"
        );
        $data->boosterSeatAmount = $this->sumColumn(
            $collection,
            "booster_seat_amount"
        );
        $data->reservedTablesAmount = $this->sumColumn(
            $collection,
            "table_amount"
        );

        return $data;
    }

    private function sumColumn(Collection $collection, string $column): int
    {
        return $collection->sum($column);
    }

    private function filterValidationFails(): bool
    {
        if (empty(request("from"))) {
            return true;
        }

        if (empty(request("to"))) {
            return true;
        }

        return false;
    }
}
