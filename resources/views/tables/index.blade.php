@extends("layouts.main")

@section("title", "test2")

@section("content")
    show me {{ $seatedSelected }}
    @include("tables.sections.areaFilter",['route' => $areaSelected,'items' => ['terrace','ground floor','first floor'],'currentSelection' => $seatedSelected])
    @include("tables.sections.seatedFilter",['route' => $seatedSelected,'items' => ['seated','available'],'currentSelection' => $areaSelected])

    @foreach ($tables as $table)
        <div class="m-3 flex w-max rounded-lg border-2 bg-slate-300 p-3">
            <div>
                <div>table number: {{ $table->table_number }}</div>
                <div>capacity: {{ $table->capacity }}</div>
                <div>seating area: {{ $table->seating_area }}</div>
            </div>
            <div class="m-3">
                <a href="/order/{{ $table->table_number }}" class="">
                    <x-add-circle-icon />
                </a>
            </div>
        </div>
    @endforeach
@endsection
