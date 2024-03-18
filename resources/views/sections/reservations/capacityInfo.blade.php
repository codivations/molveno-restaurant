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
    <div>Tables reserved: {{ $data->reservedTablesAmount }}</div>
    <div>Total high chairs: {{ $data->highChairAmount }}</div>
    <div>Total booster seats: {{ $data->boosterSeatAmount }}</div>
</div>
