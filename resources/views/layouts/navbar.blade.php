<nav class="flex">
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
</nav>
