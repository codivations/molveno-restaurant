<nav x-data="{ open: false }" class="flex flex-col">
    <div
        x-show="open"
        class="flex w-max flex-col gap-3 self-end bg-black p-3"
    >
        <x-dropdown-link
            class="rounded-lg border border-white"
            :href="route('index')"
        >
            Home
        </x-dropdown-link>
        <form method="POST" action="{{ route("logout") }}">
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
    <div class="flex max-w-full justify-evenly gap-1 bg-black p-2">
        <x-nav-button
            :href="__('/tables')"
            :active="__(Route::is('tables.all')||Route::is('tables.filtered'))"
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
        <button
            @click="open = ! open"
            @click.outside="open = false"
            class="nav-bg text-2xs flex h-16 w-16 flex-shrink-0 flex-col items-center justify-center rounded-md p-2"
        >
            <x-settings-icon />
        </button>
    </div>
</nav>
