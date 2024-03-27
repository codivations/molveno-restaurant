<div class="filter-settings">
    <div>
        From: {{ (new DateTime($filterData->from))->format("d/m/y - H:i") }}
    </div>
    <div>To: {{ (new DateTime($filterData->to))->format("d/m/y - H:i") }}</div>
    <div>
        Selected seating area:
        <span class="capitalize">
            {{ $filterData->seating_area ?? "All" }}
        </span>
    </div>
</div>
<div class="capacity-info">
    @if ($filterData->seating_area == \App\Enums\SeatingArea::ALL)
        <div>
            Tables reserved:
            {{ $overviewData->capacityTotals->reservedTablesAmount }}
        </div>
        <div>
            - Terrace:
            {{ $overviewData->capacityTerrace->reservedTablesAmount }}
        </div>
        <div>
            - Ground Floor:
            {{ $overviewData->capacityGroundFloor->reservedTablesAmount }}
        </div>
        <div>
            - First Floor:
            {{ $overviewData->capacityFirstFloor->reservedTablesAmount }}
        </div>

        <div>
            High chairs reserved:
            {{ $overviewData->capacityTotals->highChairAmount }}
        </div>
        <div>
            - Terrace: {{ $overviewData->capacityTerrace->highChairAmount }}
        </div>
        <div>
            - Ground Floor:
            {{ $overviewData->capacityGroundFloor->highChairAmount }}
        </div>
        <div>
            - First Floor:
            {{ $overviewData->capacityFirstFloor->highChairAmount }}
        </div>

        <div>
            Booster seats reserved:
            {{ $overviewData->capacityTotals->boosterSeatAmount }}
        </div>
        <div>
            - Terrace: {{ $overviewData->capacityTerrace->boosterSeatAmount }}
        </div>
        <div>
            - Ground Floor:
            {{ $overviewData->capacityGroundFloor->boosterSeatAmount }}
        </div>
        <div>
            - First Floor:
            {{ $overviewData->capacityFirstFloor->boosterSeatAmount }}
        </div>
    @else
        <div>
            Tables reserved:
            {{ $overviewData->capacityTotals->reservedTablesAmount }}
        </div>
        <div>
            High chairs reserved:
            {{ $overviewData->capacityTotals->highChairAmount }}
        </div>
        <div>
            Booster seats reserved:
            {{ $overviewData->capacityTotals->boosterSeatAmount }}
        </div>
    @endif
</div>
