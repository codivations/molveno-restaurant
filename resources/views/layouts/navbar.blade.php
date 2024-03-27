<nav class="flex pb-6">
    <x-nav-button :href="__('/order')">
        <x-home-icon />
    </x-nav-button>
    <x-nav-button :href="__('/order/' . $tableNumber . '/drinks')">
        <x-menu-icon />
    </x-nav-button>
    <x-nav-button :href="__('/order/' . $tableNumber . '/showOrder')">
        <x-order-icon />
    </x-nav-button>
    <x-nav-button :href="__('/reservations')">
        <x-reservations-icon />
    </x-nav-button>
    <div
        class="nav-bg flex w-20 flex-col items-center justify-center rounded-md text-xs"
    >
        <x-settings-icon />
    </div>
</nav>
