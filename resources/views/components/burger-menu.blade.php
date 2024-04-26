<div class="flex flex-col self-center">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="hamburger-button">
                <x-burger-icon />
            </button>
        </x-slot>
        <x-slot name="content">
            <p class="hamburger-name">{{ Auth::user()->name }}</p>
            <x-responsive-nav-link
                :href="route('index')"
                :active="request()->routeIs('index')"
                class="mb-2"
            >
                Home
            </x-responsive-nav-link>
            <x-responsive-nav-link
                :href="route('reservations.index')"
                :active="request()->routeIs('reservations.*')"
                class="mb-2"
            >
                Reservations
            </x-responsive-nav-link>
            <x-responsive-nav-link
                :href="route('tables.all')"
                :active="request()->routeIs(['tables.*', 'order.*'])"
                class="mb-2"
            >
                Table & Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link
                :href="route('kitchen.index')"
                :active="request()->routeIs('kitchen.*')"
                class="mb-2"
            >
                Kitchen
            </x-responsive-nav-link>

            <form method="POST" action="{{ route("logout") }}">
                @csrf

                <x-responsive-nav-link
                    :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();"
                >
                    {{ __("Log Out") }}
                </x-responsive-nav-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
