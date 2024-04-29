@extends("layouts.main")

@section("content")
    <div
        class="bg-dots-darker dark:bg-dots-lighter min-h-screen bg-gray-100 selection:bg-red-500 selection:text-white dark:bg-gray-900"
    >
        @auth
            @section("title")
                welcome
            @endsection

            @include("index")
        @else
            @section("title")
                Log In
            @endsection

            <div class="sm:flex sm:items-center sm:justify-center">
                @include("auth.login")
            </div>
        @endauth
    </div>
@endsection
