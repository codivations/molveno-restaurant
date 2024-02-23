@extends("layouts.main")

@section("title", "test2")

@section("content")
    <h1 class="text-blue-600">Hello World</h1>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route("login") }}">
        @csrf

        {{-- name --}}
        <div></div>
    </form>
@endsection
