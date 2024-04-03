<nav x-data="{ open: false }" class="flex flex-col">
    <div x-show="open" class="flex w-fit flex-col self-end bg-black">
        <form method="POST" action="{{ route("logout") }}" class="p-3">
            @csrf

            <x-dropdown-link
                class="rounded-lg border border-white"
                :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();"
            >
                {{ __("Log Out") }}
            </x-dropdown-link>
        </form>
    </div>
    <div class="flex gap-2 bg-black p-2">
        <x-nav-button
            :href="__('/order')"
            :active="__(Route::is('order.index'))"
        >
            <x-home-icon />
        </x-nav-button>
        <x-nav-button
            :href="__('/order/' . $tableNumber . '/drinks')"
            :active="__(Route::is('order.showService'))"
        >
            <x-menu-icon />
        </x-nav-button>
        <x-nav-button
            :href="__('/order/' . $tableNumber . '/showOrder')"
            :active="__(Route::is('order.showOrder'))"
        >
            <x-order-icon />
        </x-nav-button>
        <x-nav-button
            :href="__('/reservations')"
            :active="__(Route::is('reservations.index'))"
        >
            <x-reservations-icon />
        </x-nav-button>
        <div
            class="nav-bg flex w-20 flex-col items-center justify-center rounded-md text-xs"
            x-data=""
        >
            <button @click="open = ! open" @click.outside="open = false">
                <x-settings-icon />
            </button>
        </div>
    </div>
</nav>
