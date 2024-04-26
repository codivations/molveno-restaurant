<div class="flex">
    <!-- Logo -->
    <div class="flex shrink-0 items-center">
        <a href="{{ route("index") }}">
            <x-application-logo />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link
            :href="route('index')"
            :active="request()->routeIs('index')"
        >
            {{ __("Dashboard") }}
        </x-nav-link>
    </div>
</div>
