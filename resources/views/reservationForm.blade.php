@extends("layouts.main")

@section("title", "test2")

@section("content")
    <h1 class="text-blue-600">New reservation</h1>
    @include("sections.addReservationForm")
@endsection
