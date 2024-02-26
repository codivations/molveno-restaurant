<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route("login") }}">
        @csrf

        <!-- Login Name -->
        <div>
            <x-input-label for="login_name" :value="__('Name')" />
            <x-text-input
                id="login_name"
                class="mt-1 block w-full"
                type="text"
                name="login_name"
                :value="old('login_name')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error
                :messages="$errors->get('login_name')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-8 flex items-center justify-end">
            <x-primary-button class="ms-3">
                {{ __("Log in") }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
