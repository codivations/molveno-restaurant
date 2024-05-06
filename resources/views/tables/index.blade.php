@extends("layouts.main")

@section("title", "tables")

@section("content")
    <div class="order-grid">
        <nav class="top-nav">
            @include("tables.sections.areaFilter",['route' => $seatedSelected,'items' => ['terrace','ground floor','first floor'],'currentSelection' => $areaSelected])
            @include("tables.sections.seatedFilter",['route' => $areaSelected,'items' => ['occupied','available'],'currentSelection' => $seatedSelected])
        </nav>
        <section class="flex flex-col gap-2" x-data="{ item_open: null }">
            @foreach ($tables as $table)
                <div
                    class="rounded-lg border border-black bg-white"
                    @click="item_open = item_open == {{ $table->id }} ? null : {{ $table->id }} "
                >
                    <div
                        class="{{ $table->seated ? "occupied" : "unoccupied" }} select-none rounded-t-lg p-3"
                    ></div>
                    <div class="flex flex-1 justify-between p-2">
                        <div>
                            <div class="flex w-5/6 flex-wrap justify-between">
                                <div class="font-bold uppercase">
                                    Table {{ $table->table_number }}
                                </div>
                                <div>
                                    <div>Capacity: {{ $table->capacity }}</div>
                                    <div class="first-letter:uppercase;">
                                        {{ $table->seating_area }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($table->seated)
                            <div class="m-3" @click.stop>
                                <a
                                    href="/order/{{ $table->table_number }}/drinks"
                                    class="z-10"
                                >
                                    <x-add-circle-icon />
                                </a>
                            </div>
                        @endif
                    </div>

                    <div
                        x-show="item_open == {{ $table->id }}"
                        class="flex flex-col gap-2 rounded-b-lg border border-black bg-gray-300 p-4"
                        @click.stop
                    >
                        @if ($table->seated)
                            <div
                                class="flex flex-row items-center justify-between"
                            >
                                Reservation {{ $table->seated_reservation }}:
                                {{ $table->seated->name ?? "" }}

                                <form
                                    action="/tables/unseat"
                                    method="POST"
                                    class=""
                                >
                                    @csrf
                                    <div class="hidden">
                                        <label for="table" class="form-label">
                                            #
                                        </label>
                                        <input
                                            type="text"
                                            id="table"
                                            name="table"
                                            class="form-input"
                                            value="{{ $table->id }}"
                                        />
                                    </div>

                                    <input
                                        type="submit"
                                        value="Unseat"
                                        class="button"
                                    />
                                </form>
                            </div>

                            <div class="flex w-full flex-row justify-end">
                                <a
                                    href="{{ route("order.showOrder", ["tableNumber" => $table->table_number]) }}"
                                    class="button"
                                >
                                    See orders
                                </a>
                            </div>
                        @else
                            <div>
                                <form
                                    action="/tables/seat"
                                    method="POST"
                                    class=""
                                    x-data="{ selectedname: '', selectedID: '' }"
                                >
                                    @csrf
                                    <div class="hidden">
                                        <label for="table" class="form-label">
                                            #
                                        </label>
                                        <input
                                            type="text"
                                            id="table"
                                            name="table"
                                            class="form-input"
                                            value="{{ $table->id }}"
                                        />
                                    </div>
                                    <div class="hidden">
                                        <label
                                            for="reservation-id-input"
                                            class="form-label"
                                        ></label>
                                        <input
                                            type="text"
                                            id="reservation-id-input"
                                            name="reservation"
                                            class="form-input"
                                            x-model="selectedID"
                                        />
                                    </div>
                                    <div class="reservation-search">
                                        <label
                                            for="name"
                                            class="form-label"
                                        ></label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            placeholder="Name"
                                            class="search-input"
                                            @input="selectedID = filterReservations(event)"
                                            x-model="selectedname"
                                            autocomplete="off"
                                        />
                                        <div class="reservation-search-list">
                                            @foreach ($reservations as $reservation)
                                                <div
                                                    class="reservation-search-item hidden"
                                                    id="{{ $reservation->id }}"
                                                    @click="selectedname = `{{ $reservation->name }}`, selectedID = `{{ $reservation->id }}`"
                                                >
                                                    {{ $reservation->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <input
                                        type="submit"
                                        value="submit"
                                        class="button"
                                    />
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <script>
                function filterReservations(event) {
                    let elements = Array.from(
                        event.target.parentNode
                            .getElementsByClassName(
                                'reservation-search-list'
                            )[0]
                            .getElementsByClassName('reservation-search-item')
                    );

                    if (!elements || elements.length == 0) {
                        return '';
                    }

                    let search = event.target.value.trim().toLowerCase();

                    if (search == '') {
                        hideElements(elements);
                        return;
                    }

                    let matches = filterMatchingElements(search, elements);
                    let firstMatchID = 'test';
                    if (matches && matches.length > 0) {
                        firstMatchID = matches[0].id;
                    }

                    return firstMatchID;
                }

                //text search
                function filterMatchingElements(search, elements) {
                    let matches = [];
                    elements.forEach((element) => {
                        let text = element.innerHTML.toLowerCase();

                        if (textContains(text, search)) {
                            showElement(element);
                            matches.push(element);
                        } else {
                            hideElement(element);
                        }
                    });

                    return matches;
                }

                function textContains(text, search, startsWith = false) {
                    if (startsWith) {
                        return (
                            search.localeCompare(
                                text.substring(0, search.length)
                            ) == 0
                        );
                    }

                    return text.includes(search);
                }

                //display elements
                function hideElement(element) {
                    element.classList.add('hidden');
                }

                function hideElements(elements) {
                    elements.forEach((element) => {
                        hideElement(element);
                    });
                }

                function showElement(element) {
                    element.classList.remove('hidden');
                }

                function showElements(elements) {
                    elements.forEach((element) => {
                        showElement(element);
                    });
                }
            </script>
        </section>
        <footer class="bottom-nav">
            @include("layouts.navbar",['tableNumber' => 0])
        </footer>
    </div>
@endsection
