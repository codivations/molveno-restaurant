<?php

namespace App\Http\Controllers;

use App\Enums\SeatingArea;
use Illuminate\Http\Request;
use App\Models\Reservations;
use App\Models\Table;
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

        $filterData = session("filterData");

        $reservations = $this->getFilteredReservations(
            $filterData->seating_area,
            new DateTime($filterData->from),
            new DateTime($filterData->to),
            $filterData->service
        );

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
    public function storeNew(Request $request): View|RedirectResponse
    {
        $request->validate($this->getValidationRules());

        $reservation = new Reservations();
        $this->store($reservation, $request);

        return redirect("/reservations")->with(
            "message",
            "Reservation added succesfully"
        );
    }

    private function store($reservation, Request $request)
    {
        $reservation->name = trim($request->name);
        $reservation->party_size = $request->party_size;
        $reservation->table_amount = ceil($request->party_size / 2);
        $reservation->phone_number = trim($request->phone_number);
        $reservation->reservation_time = $request->reservation_time;
        $reservation->seating_area = trim($request->seating_area);
        $reservation->high_chair_amount = $request->high_chair_amount;
        $reservation->booster_seat_amount = $request->booster_seat_amount;
        $reservation->dietary_restrictions = $request->has(
            "dietary_restrictions"
        );
        $reservation->notes = trim($request->notes);
        $reservation->save();
    }

    private function getValidationRules()
    {
        return [
            "name" => "required|string|between:2,255",
            "party_size" => "required|integer|gte:1",
            "phone_number" => "required|string|regex:/^([0-9\s\-\+\.()]*)+$/",
            "reservation_time" => "required|date|after:today",
            "service" => "required",
            "seating_area" => "required",
            "high_chair_amount" => "required|integer|gte:0",
            "booster_seat_amount" => "required|integer|gte:0",
            "dietary_restrictions" => "nullable|integer",
            "notes" => "string|nullable",
        ];
    }

    public function editReservation(
        Request $request,
        string $id
    ): View|RedirectResponse {
        $selectedReservation = $this->getReservationById($id);

        $request->validate(
            array_merge(
                [
                    "id" => "required|integer|gte:0",
                ],
                $this->getValidationRules()
            )
        );

        if ($selectedReservation) {
            $this->store($selectedReservation, $request);

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
    private function getFilteredReservations(
        SeatingArea $seatingArea,
        DateTime $from,
        DateTime $to,
        string $service = "all"
    ): Collection {
        $reservation = Reservations::orderBy("reservation_time")->whereDate(
            "reservation_time",
            $from->format("Y-m-d")
        );

        if ($service != "all") {
            $reservation->where("service", $service);
        }

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
        $filterData->service = $request->service;

        $filterData->seating_area = SeatingArea::tryFrom($request->area);

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
        $filterData->service = "all";

        $filterData->seating_area = SeatingArea::ALL;

        return $filterData;
    }

    //FIXME: Implement proper validation and/or remove
    private function filterValidationFails(): bool
    {
        if (empty(request("from"))) {
            return true;
        }

        // if (empty(request("to"))) {
        //     return true;
        // }

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

    private function getCapacityDataObject(
        Collection $collection,
        object $filterData
    ): object {
        $data = new stdClass();
        $data->capacityTotals = $this->getOverviewDataObj($collection);

        $filteredReservations = Reservations::whereDate(
            "reservation_time",
            $filterData->from->format("Y-m-d")
        );

        //FIXME: the rest of the function

        return $data;
    }

    private function getCapacityDataFor($date, $area, $service): object
    {
        $data = new stdClass();
        $data->totalCapacity = $this->getTotalCapacity($area);

        $reservations = Reservations::where("seating_area", $area)
            ->where("service", $service)
            ->whereDate("reservation_time", $date->format("Y-m-d"));

        $data->tableAmount = $reservations->sum("table_amount");
        $data->highChairAmount = $reservations->sum("table_amount");
        $data->boosterSeatAmount = $reservations->sum("table_amount");

        return $data;
    }

    private function getTotalCapacity($area): int
    {
        $collection = Table::where("seating_area", $area)->get;
        $total = $collection->sum("capacity");
        return $total;
    }

    //FIXME: -> This values needs to be put in a database somewhere
    private function getBoosterSeatTotal(): int
    {
        return 10;
    }

    //FIXME: -> This values needs to be put in a database somewhere
    private function getHighChairTotal(): int
    {
        return 15;
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
