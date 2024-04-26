<x-index.header />

@session("status")
    <p class="text-red-500">{{ session("status") }}</p>
@endsession
