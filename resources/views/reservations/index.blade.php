@extends("layouts.main")
@section("title", "reservations")

@section("content")
    <div class="reservations-content bg-gray-600" x-data="{ open: false }">
        <div class="topbar flex flex-row items-center justify-between">
            <button class="button" x-on:click="open = ! open">
                Filters
            </button>
            <div class="flex items-center gap-10">
                <a href="/reservations/new" class="button">new</a>
                <x-burger-menu />
            </div>
        </div>
        <div class="content-body flex flex-row p-5">
            <div class="content-list flex basis-1/3 flex-col p-2">
                <div class="filters" x-show="open">
                    @include("reservations.sections.filters")
                </div>
                <ul
                    class="w-180 max-h-dvh overflow-y-scroll rounded-lg border border-solid bg-slate-300"
                >
                    @foreach ($reservations as $reservation)
                        @include("reservations.sections.infoCard")
                    @endforeach
                </ul>
            </div>
            <div class="m-2 basis-2/3 rounded bg-gray-200 shadow">
                @switch($displayData->display)
                    @case("details")
                        @if ($displayData->data != null)
                            @php
                                $selectedReservation = $displayData->data;
                            @endphp

                            @include("reservations.sections.details")
                        @else
                            <div>
                                <span>
                                    error: no valid reservation selected
                                </span>
                            </div>
                        @endif

                        @break
                    @case("new form")
                        @include("reservations.sections.addForm")

                        @break
                    @case("edit form")
                        @php
                            $selectedReservation = $displayData->data;
                        @endphp

                        @include("reservations.sections.editForm")

                        @break
                    @case("result")
                        <div
                            class="modal"
                            x-data="{ modalOpen: true }"
                            x-show="modalOpen"
                        >
                            <div class="dialog-box">
                                <div class="dialog-text w-fit text-center">
                                    {{ $displayData->message }}
                                </div>
                                <div class="button-row">
                                    <button
                                        class="button"
                                        x-on:click="modalOpen = ! modalOpen"
                                    >
                                        Ok
                                    </button>
                                </div>
                            </div>
                        </div>
                    @default
                        @php
                            $overviewData = $displayData->data;
                        @endphp

                        <div>
                            @include("reservations.sections.capacityInfo")
                        </div>
                @endswitch
            </div>
        </div>
    </div>
@endsection
