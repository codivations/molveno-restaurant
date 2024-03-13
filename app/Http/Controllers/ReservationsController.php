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
        $selectedReservation = $this->getReservationById($id);

        return back()
            ->withInput()
            ->with("selectedReservation", $selectedReservation);
    }

    public function showFilteredOverview(Request $request)
    {
        if ($this->filterValidationFails($errors)) {
            //dd("don't want to see this");
            return $this->showUnfilteredOverview();
        }

        $reservations = $this->getReservationsInBetweenDateTimes(
            new DateTime($request->from),
            new DateTime($request->to)
        );
        $filterData = $this->getFilterDataObj($request);

        return $this->showOverview($reservations, $filterData);
    }

    public function showUnfilteredOverview()
    {
        $reservations = $this->getAllReservations();

        return $this->showOverview($reservations);
    }

    public function showOverview(
        Collection $reservations,
        object $filterInfo = null
    ) {
        $data = $this->getOverviewDataObj($reservations);
        $filterData = $filterInfo;

        $selectedReservation = $this->getReservationById(
            $reservations->first()->id
        );
        //$selectedReservation = $this->getReservationById(3);

        return view(
            "reservationsOverview",
            compact(["data", "filterData", "reservations"])
        );
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

    private function getReservationsForCurrentDate(): Collection
    {
        return $this->getReservationsOfDate(new DateTime());
    }

    private function getReservationsOfDate(DateTime $date): Collection
    {
        return Reservations::orderBy("reservation_time")
            ->whereDate("reservation_time", $date)
            ->get();
    }

    private function getReservationById(string $id)
    {
        return Reservations::where("id", $id)->first();
    }
    #endregion

    private function sumColumn(Collection $collection, string $column): int
    {
        //$collection = Reservations::where($column, '>', 0)->get();
        return $collection->sum($column);
    }

    private function getFilterDataObj(Request $request): object
    {
        $filterData = new stdClass();

        // $filterData->from = new DateTime($request->from);
        // $filterData->to = new DateTime($request->to);
        //dd($request->from);
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

    private function filterValidationFails(&$inputErrors): bool
    {
        $errors = [];

        if (empty(request("from"))) {
            $errors["from"] =
                "Dit veld mag niet leeg zijn. Geef een eind datum aan!";
        }

        if (empty(request("to"))) {
            $errors["to"] =
                "Dit veld mag niet leeg zijn. Geef een eind datum aan!";
        }

        if (count($errors) == 0) {
            $inputErrors = null;
            return false;
        } else {
            $inputErrors = $errors;
            return true;
        }
    }
}
