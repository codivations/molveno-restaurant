<x-index.header />
<div class="flex flex-col items-center gap-4 p-3">
    <div>
        <h1 class="text-2xl text-black dark:text-white">
            Welcome
            <span>{{ Auth::user()->name }}</span>
        </h1>

        @session("status")
            <p class="text-red-500">{{ session("status") }}</p>
        @endsession
    </div>

    <div class="flex flex-col items-center gap-4">
        <h2 class="text-xl text-black dark:text-white">Navigation</h2>
        <nav class="flex gap-5">
            <x-nav-link :href="route('reservations.index')" class="text-xl">
                Reservations
            </x-nav-link>
            <x-nav-link :href="route('tables.all')" class="text-xl">
                Tables & Orders
            </x-nav-link>
            <x-nav-link :href="route('kitchen.index')" class="text-xl">
                Kitchen
            </x-nav-link>
        </nav>
    </div>
</div>
