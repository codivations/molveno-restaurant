<?php

namespace App\Http\Controllers;

use App\Enums\SeatingArea;
use Illuminate\Http\Request;
use App\Models\Reservations;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use stdClass;
use Illuminate\View\View;

class ReservationsController extends Controller
{
    #region Show Views
    public function show(object $display = null)
    {
        if (!session("filterData")) {
            $this->showUnfilteredOverview();
        }

        $reservations = $this->getFilteredReservations(
            session("filterData")->seating_area,
            new DateTime(session("filterData")->from),
            new DateTime(session("filterData")->to)
        );

        $filterData = session("filterData");

        $overviewData = $this->getOverviewData($reservations, $filterData);
        if ($display == null) {
            $displayData = $display = $this->getDisplayDataObj(
                "overview",
                $overviewData
            );
        }
        if ($display->display == "message") {
            $displayData = $this->getDisplayDataObj(
                "overview",
                $overviewData,
                $display->message
            );
        } else {
            $displayData = $display;
        }

        return view(
            "reservations/index",
            compact(["filterData", "reservations", "displayData"])
        );
    }

    public function showFilteredOverview(Request $request)
    {
        if ($this->filterValidationFails()) {
            //TODO: add proper validation and pass error messages
            //dd("filter not properly set");
            return $this->showUnfilteredOverview();
        }

        session(["reservationViewFiltered" => true]);
        session(["filterData" => $this->getFilterDataObj($request)]);

        return $this->show();
    }

    public function showUnfilteredOverview()
    {
        session(["reservationViewFiltered" => false]);
        session(["filterData" => $this->getDefaultFilterDataObj()]);

        return $this->show();
    }

    public function showReservation(string $id)
    {
        $selectedReservation = $this->getReservationById($id);
        $displayData = $this->getDisplayDataObj(
            "details",
            $selectedReservation
        );

        return $this->show($displayData);
    }

    public function showForm()
    {
        $displayData = $this->getDisplayDataObj("new form");

        return $this->show($displayData);
    }

    public function showEditForm(Request $request, string $id)
    {
        $selectedReservation = $this->getReservationById($id);
        $displayData = $this->getDisplayDataObj(
            "edit form",
            $selectedReservation
        );

        return $this->show($displayData);
    }
    #endregion Show Views

    #region Create Update & Destroy Reservations
    public function store(Request $request): View|RedirectResponse
    {
        $request->validate([
            "name" => "required|string|between:2,255",
            "party_size" => "required|integer|gte:1",
            //"table_amount" => "required|integer|gte:0",
            "phone_number" => "required|string|regex:/^([0-9\s\-\+\.()]*)+$/",
            "reservation_time" => "required|date|after:today",
            "service" => "required",
            "seating_area" => "required",
            "high_chair_amount" => "required|integer|gte:0",
            "booster_seat_amount" => "required|integer|gte:0",
            "dietary_restrictions" => "nullable|integer",
            "notes" => "string|nullable",
        ]);

        $reservation = new Reservations();
        $reservation->name = trim($request->name);
        $reservation->party_size = $request->party_size;
        $reservation->table_amount = ceil($request->party_size / 2);
        $reservation->phone_number = trim($request->phone_number);
        $reservation->reservation_time = $request->reservation_time;
        $reservation->notes = trim($request->notes);
        $reservation->seating_area = trim($request->seating_area);
        $reservation->high_chair_amount = $request->high_chair_amount;
        $reservation->booster_seat_amount = $request->booster_seat_amount;
        $reservation->dietary_restrictions = $request->has(
            "dietary_restrictions"
        );
        $reservation->save();

        return redirect("/reservations")->with(
            "message",
            "Reservation added succesfully"
        );
    }

    public function editReservation(
        Request $request,
        string $id
    ): View|RedirectResponse {
        $selectedReservation = $this->getReservationById($id);

        $request->validate([
            "id" => "required|integer|gte:0",
            "name" => "required|string|between:2,255",
            "party_size" => "required|integer|gte:1",
            //"table_amount" => "required|integer|gte:0",
            "phone_number" => "required|string|regex:/^([0-9\s\-\+\.()]*)+$/",
            "reservation_time" => "required|date|after:today",
            "service" => "required",
            "seating_area" => "required",
            "high_chair_amount" => "required|integer|gte:0",
            "booster_seat_amount" => "required|integer|gte:0",
            "dietary_restrictions" => "nullable|integer",
            "notes" => "string|nullable",
        ]);

        if ($selectedReservation) {
            $selectedReservation->name = trim($request->name);
            $selectedReservation->party_size = $request->party_size;
            $selectedReservation->table_amount = ceil($request->party_size / 2);
            $selectedReservation->phone_number = trim($request->phone_number);
            $selectedReservation->reservation_time = $request->reservation_time;
            $selectedReservation->seating_area = trim($request->seating_area);
            $selectedReservation->high_chair_amount =
                $request->high_chair_amount;
            $selectedReservation->booster_seat_amount =
                $request->booster_seat_amount;
            $selectedReservation->dietary_restrictions = $request->has(
                "dietary_restrictions"
            );
            $selectedReservation->notes = trim($request->notes);
            $selectedReservation->save();

            $result = join(" ", [
                "edited reservation for",
                $selectedReservation->name,
            ]);
        } else {
            $result =
                "Failed to edit selected Reservation. Reservation not found in database";
        }

        $displayData = $this->getDisplayDataObj(
            "details",
            $selectedReservation,
            $result
        );

        return $this->show($displayData);
    }

    public function deleteReservation(
        Request $request,
        string $id
    ): View|RedirectResponse {
        $selectedReservation = $this->getReservationById($id);

        $request->validate(["id" => "required|integer|gte:0"]);

        if ($selectedReservation) {
            $selectedReservation->delete();
            $result = join(" ", [
                "Deleted reservation for",
                $selectedReservation->name,
            ]);
        } else {
            $result =
                "Failed to delete selected Reservation. Reservation not found in database";
        }

        $displayData = $this->getDisplayDataObj("message", null, $result);

        return $this->show($displayData);
    }
    #endregion Create Update & Destroy Reservations

    #region Read Reservations
    private function getAllReservations(
        string $orderedBy = "reservation_time"
    ): Collection {
        return Reservations::orderBy($orderedBy)->get();
    }

    private function getFilteredReservations(
        SeatingArea $seatingArea,
        DateTime $from,
        DateTime $to
    ): Collection {
        $reservation = Reservations::orderBy("reservation_time")->whereBetween(
            "reservation_time",
            [$from, $to]
        );

        if ($seatingArea != SeatingArea::ALL) {
            $reservation->where("seating_area", $seatingArea);
        }

        return $reservation->get();
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

        switch ($request->area) {
            case "terrace":
                $filterData->seating_area = SeatingArea::TERRACE;
                break;

            case "ground floor":
                $filterData->seating_area = SeatingArea::GROUNDFLOOR;
                break;

            case "first floor":
                $filterData->seating_area = SeatingArea::FIRSTFLOOR;
                break;

            default:
                $filterData->seating_area = SeatingArea::ALL;
                break;
        }

        return $filterData;
    }

    private function getDefaultFilterDataObj()
    {
        $filterData = new stdClass();

        $filterData->from = date_time_set(new DateTime(), 0, 00)->format(
            "Y-m-d H:i"
        );
        $filterData->to = date_time_set(new DateTime(), 23, 59)->format(
            "Y-m-d H:i"
        );

        $filterData->seating_area = SeatingArea::ALL;

        return $filterData;
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

    private function getOverviewDataObj(Collection $collection): object
    {
        $data = new stdClass();
        $data->highChairAmount = $collection->sum("high_chair_amount");
        $data->boosterSeatAmount = $collection->sum("booster_seat_amount");
        $data->reservedTablesAmount = $collection->sum("table_amount");

        return $data;
    }

    private function getOverviewData(
        Collection $collection,
        object $filterData
    ): object {
        $data = new stdClass();
        $data->capacityTotals = $this->getOverviewDataObj($collection);

        if ($filterData->seating_area == SeatingArea::ALL || false) {
            $filteredReservations = $collection->filter(function (
                $value,
                $key
            ) {
                if ($value["seating_area"] == "terrace") {
                    return $value;
                }
            });

            $data->capacityTerrace = $this->getOverviewDataObj(
                $filteredReservations
            );

            $filteredReservations = $collection->filter(function (
                $value,
                $key
            ) {
                if ($value["seating_area"] == "ground floor") {
                    return $value;
                }
            });
            $data->capacityGroundFloor = $this->getOverviewDataObj(
                $filteredReservations
            );

            $filteredReservations = $collection->filter(function (
                $value,
                $key
            ) {
                if ($value["seating_area"] == "first floor") {
                    return $value;
                }
            });
            $data->capacityFirstFloor = $this->getOverviewDataObj(
                $filteredReservations
            );
        }

        return $data;
    }

    private function getDisplayDataObj(
        string $display = "default",
        $data = null,
        string $message = null
    ): object {
        $displayData = new stdClass();

        $displayData->display = $display;
        $displayData->data = $data;
        $displayData->message = $message;

        return $displayData;
    }
}
