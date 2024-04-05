@extends("layouts.main")

@section("title", "test2")

@section("content")
    @include("tables.sections.areaFilter",['route' => $seatedSelected,'items' => ['terrace','ground floor','first floor'],'currentSelection' => $areaSelected])
    @include("tables.sections.seatedFilter",['route' => $areaSelected,'items' => ['occupied','available'],'currentSelection' => $seatedSelected])

    @foreach ($tables as $table)
        <div class="m-3 flex w-max rounded-lg border-2 bg-slate-300 p-3">
            <div>
                <div>table number: {{ $table->table_number }}</div>
                <div>capacity: {{ $table->capacity }}</div>
                <div>seating area: {{ $table->seating_area }}</div>
                <div>status: {{ $table->seated ? "Occupied" : "Free" }}</div>
                @if ($table->seated)
                    <div>
                        seated reservation id: {{ $table->seated_reservation }}
                    </div>
                    <div>
                        seated reservation name:
                        {{ $table->seated->name ?? "" }}
                    </div>
                @endif
            </div>
            <div class="m-3">
                <a href="/order/{{ $table->table_number }}" class="">
                    <x-add-circle-icon />
                </a>
            </div>
        </div>
    @endforeach
@endsection
