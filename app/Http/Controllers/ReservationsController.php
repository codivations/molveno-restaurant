<?php

namespace App\Http\Controllers;

use App\Enums\SeatingArea;
use App\Models\Reservations;
use App\Models\Table;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use stdClass;

class ReservationsController extends Controller
{
    //region Show Views
    public function show(?object $display = null): View
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

        if (session("display")) {
            $displayData = session("display");
        } elseif ($display) {
            $displayData = $display;
        } else {
            $displayData = $this->getDisplayDataObj("overview", $overviewData);
        }

        if (session("message") != null) {
            $displayData->message = session("message");
        }

        return view(
            "reservations/index",
            compact(["filterData", "reservations", "displayData"])
        );
    }

    public function showFilteredOverview(Request $request): RedirectResponse
    {
        if ($this->filterValidationFails()) {
            //FIXME: add proper validation and pass error messages
            return $this->showUnfilteredOverview();
        }

        session(["reservationViewFiltered" => true]);
        session(["filterData" => $this->getFilterDataObj($request)]);

        return redirect()->route("reservations.index", ["display" => null]);
    }

    public function showUnfilteredOverview(): RedirectResponse
    {
        session(["reservationViewFiltered" => false]);
        session(["filterData" => $this->getDefaultFilterDataObj()]);

        return redirect()->route("reservations.index", ["display" => null]);
    }

    public function showReservation(string $id): RedirectResponse|View
    {
        $selectedReservation = $this->getReservationById($id);

        if (!$selectedReservation) {
            $message =
                "Could not find reservation in database. It may have been deleted";
            return redirect()
                ->route("reservations.index")
                ->with(["message" => $message]);
        }

        $displayData = $this->getDisplayDataObj(
            "details",
            $selectedReservation
        );

        return $this->show($displayData);
    }

    public function showForm(): View
    {
        $displayData = $this->getDisplayDataObj("new form");

        return $this->show($displayData);
    }

    public function showEditForm(string $id): View
    {
        $selectedReservation = $this->getReservationById($id);
        $displayData = $this->getDisplayDataObj(
            "edit form",
            $selectedReservation
        );

        return $this->show($displayData);
    }
    //endregion Show Views

    //region Create Update & Destroy Reservations
    public function storeNew(Request $request): View|RedirectResponse
    {
        $request->validate($this->getValidationRules());

        $reservation = new Reservations();
        if ($this->store($reservation, $request)) {
            return redirect()
                ->route("reservations.index")
                ->with(["message" => "Reservation added succesfully"])
                ->withInput();
        }

        return back()->with([
            "message" => "Error failed to add reservation to database",
        ]);
    }

    private function store($reservation, Request $request): bool
    {
        $reservation->name = trim($request->name);
        $reservation->party_size = $request->party_size;
        $reservation->table_amount = ceil($request->party_size / 2);
        $reservation->phone_number = trim($request->phone_number);
        $reservation->service = trim($request->service);
        $reservation->reservation_time = $request->reservation_time;
        $reservation->seating_area = trim($request->seating_area);
        $reservation->high_chair_amount = $request->high_chair_amount;
        $reservation->booster_seat_amount = $request->booster_seat_amount;
        $reservation->dietary_restrictions = $request->has(
            "dietary_restrictions"
        );
        $reservation->notes = trim($request->notes);
        $reservation->save();

        $result = Reservations::where("name", "=", $reservation->name)
            ->where("reservation_time", "=", $reservation->reservation_time)
            ->where("phone_number", "=", $reservation->phone_number)
            ->where("party_size", "=", $reservation->party_size)
            ->first();

        return $result != null;
    }

    private function getValidationRules(): array
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

            $result = implode(" ", [
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

        return redirect()
            ->route("reservations.index")
            ->with(["display" => $displayData]);
    }

    public function deleteReservation(
        Request $request,
        string $id
    ): View|RedirectResponse {
        $selectedReservation = $this->getReservationById($id);

        $request->validate(["id" => "required|integer|gte:0"]);

        foreach ($selectedReservation->tables as $table) {
            $table->unseatReservation();
        }

        if ($selectedReservation) {
            $selectedReservation->delete();
            $query = Reservations::find($selectedReservation->id);
            if ($query != null) {
                $result = "ERROR! Failed to delete reservation from database";
                return back()->with(["message" => $result]);
            }
            $result = implode(" ", [
                "Deleted reservation for",
                $selectedReservation->name,
            ]);
        } else {
            $result =
                "Failed to delete selected Reservation. Reservation not found in database";
        }

        return redirect()
            ->route("reservations.index")
            ->with(["message" => $result]);
    }
    //endregion Create Update & Destroy Reservations

    //region Read Reservations
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
    //endregion

    private function getFilterDataObj(Request $request): object
    {
        $filterData = new stdClass();

        $array = explode("-", $request->from);
        $date = Carbon::createFromDate($array[0], $array[1], $array[2], +1);

        $filterData->from = $date;
        $filterData->date = $request->from;

        $filterData->to = $request->to;
        $filterData->service = $request->service;

        $filterData->seating_area = SeatingArea::tryFrom($request->area);

        return $filterData;
    }

    private function getDefaultFilterDataObj(): object
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
        ?string $message = null
    ): object {
        $displayData = new stdClass();

        $displayData->display = $display;
        $displayData->data = $data;
        $displayData->message = $message;

        return $displayData;
    }
}
