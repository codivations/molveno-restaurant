@extends("layouts.main")

@section("title", "tables")

@section("content")
    <div class="bg-gray-200 px-2">
        <nav class="sticky top-0">
            @include("tables.sections.areaFilter",['route' => $seatedSelected,'items' => ['terrace','ground floor','first floor'],'currentSelection' => $areaSelected])
            @include("tables.sections.seatedFilter",['route' => $areaSelected,'items' => ['occupied','available'],'currentSelection' => $seatedSelected])
        </nav>
        <section class="my-2 flex flex-col" x-data="{ item_open: null }">
            @foreach ($tables as $table)
                <div
                    class="mt-2 rounded-md border border-black bg-white p-4"
                    @click="item_open = item_open == {{ $table->id }} ? null : {{ $table->id }} "
                >
                    <div class="flex flex-1 justify-between">
                        <div>
                            <div class="flex w-5/6 flex-wrap justify-between">
                                <div># {{ $table->table_number }}</div>
                                <div>
                                    <div>capacity: {{ $table->capacity }}</div>
                                    <div>
                                        seating area:
                                        {{ $table->seating_area }}
                                    </div>
                                    <div>
                                        status:
                                        {{ $table->seated ? "Occupied" : "Free" }}
                                    </div>
                                </div>
                            </div>
                            @if ($table->seated)
                                <div>
                                    seated reservation id:
                                    {{ $table->seated_reservation }}
                                </div>
                                <div>
                                    seated reservation name:
                                    {{ $table->seated->name ?? "" }}
                                </div>
                            @endif
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
                        class="flex flex-col gap-2 border border-t-0 border-black bg-gray-300 p-4"
                        @click.stop
                    >
                        @if ($table->seated)
                            <div>
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
                                        value="unseat"
                                        class="button"
                                    />
                                </form>
                            </div>
                        @else
                            <div>
                                <form
                                    action="/tables/seat"
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
                                    <div class="">
                                        <label
                                            for="reservation"
                                            class="form-label"
                                        ></label>
                                        <input
                                            type="text"
                                            id="reservation"
                                            name="reservation"
                                            class="form-input"
                                        />
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
        </section>
        <footer class="sticky bottom-0 max-w-full">
            @include("layouts.navbar",['tableNumber' => 0])
        </footer>
    </div>
@endsection
