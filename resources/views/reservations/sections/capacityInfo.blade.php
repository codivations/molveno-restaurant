<div class="h-full w-full">
    <div class="flex h-full flex-col justify-between">
        <div class="container m-5 mx-auto w-2/3">
            <div class="text-center text-4xl">
                Overview for
                {{ (new DateTime($filterData->from))->format("d/m/y") }}
                @if ($filterData->service == "all")
                    <span>- all services</span>
                @else
                    <span>- {{ $filterData->service }} service</span>
                @endif
            </div>

            <div class="capacity-info">
                <div class="capacity-info text-xl">Table overview</div>

                @foreach ($overviewData->service as $serviceData)
                    @if ($filterData->service == "all" || $serviceData->service == $filterData->service)
                        <div class="capacity-info">
                            <div class="capitalize">
                                {{ $serviceData->service }} service
                            </div>
                            <div class="flex w-full flex-row justify-between">
                                <div class="w-full">
                                    @foreach ( $serviceData->capacityInfo as $capacityData )
                                        @if ($filterData->seating_area == \App\Enums\SeatingArea::ALL || $filterData->seating_area == $capacityData->area)
                                            @include("reservations.sections.capacityInfoCard")
                                        @endif
                                    @endforeach
                                </div>
                                <div class="w-full">
                                    <div
                                        class="flex w-2/4 flex-row justify-between"
                                    >
                                        <div>- Booster seats</div>
                                        <div>
                                            {{ $serviceData->boosterSeatAmount }}
                                            /
                                            {{ $serviceData->boosterSeatTotal }}
                                        </div>
                                    </div>
                                    <div
                                        class="flex w-2/4 flex-row justify-between"
                                    >
                                        <div>- High chairs</div>
                                        <div>
                                            {{ $serviceData->highChairAmount }}
                                            /
                                            {{ $serviceData->highChairTotal }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
