<div class="h-full w-full">
    <div class="flex h-full flex-col justify-between">
        <div class="container m-5 mx-auto w-2/3">
            <div class="text-center text-4xl">
                Overview for
                {{ (new DateTime($filterData->from))->format("d/m/y") }} -
                {{ $filterData->service }}
            </div>

            <div class="capacity-info">
                @if ($filterData->seating_area == \App\Enums\SeatingArea::ALL)
                    <div class="capacity-info">
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
                    </div>

                    <div class="capacity-info">
                        <div>
                            High chairs reserved:
                            {{ $overviewData->capacityTotals->highChairAmount }}
                            / 10
                        </div>
                        <div>
                            - Terrace:
                            {{ $overviewData->capacityTerrace->highChairAmount }}
                        </div>
                        <div>
                            - Ground Floor:
                            {{ $overviewData->capacityGroundFloor->highChairAmount }}
                        </div>
                        <div>
                            - First Floor:
                            {{ $overviewData->capacityFirstFloor->highChairAmount }}
                        </div>
                    </div>

                    <div class="capacity-info">
                        <div>
                            Booster seats reserved:
                            {{ $overviewData->capacityTotals->boosterSeatAmount }}
                            / 15
                        </div>
                        <div>
                            - Terrace:
                            {{ $overviewData->capacityTerrace->boosterSeatAmount }}
                        </div>
                        <div>
                            - Ground Floor:
                            {{ $overviewData->capacityGroundFloor->boosterSeatAmount }}
                        </div>
                        <div>
                            - First Floor:
                            {{ $overviewData->capacityFirstFloor->boosterSeatAmount }}
                        </div>
                    </div>
                @else
                    <div class="capacity-info">
                        <div>
                            Tables reserved:
                            {{ $overviewData->capacityTotals->reservedTablesAmount }}
                        </div>
                        <div>
                            High chairs reserved:
                            {{ $overviewData->capacityTotals->highChairAmount }}
                            / 10
                        </div>
                        <div>
                            Booster seats reserved:
                            {{ $overviewData->capacityTotals->boosterSeatAmount }}
                            / 15
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{--
            <div class="bottom-bar">
            <div class="button-row">
            
            </div>
            </div>
        --}}
    </div>
</div>
