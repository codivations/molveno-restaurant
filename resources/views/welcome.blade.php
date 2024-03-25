<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Molveno Restaurant</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="antialiased">
        <div
            class="bg-dots-darker dark:bg-dots-lighter relative min-h-screen bg-gray-100 bg-center selection:bg-red-500 selection:text-white sm:flex sm:items-center sm:justify-center dark:bg-gray-900"
        >
            <div class="mx-auto flex max-w-7xl flex-col gap-4 p-6 lg:p-8">
                @auth
                    @session("status")
                        <p class="text-red-500">{{ session("status") }}</p>
                    @endsession

                    <h1 class="text-3xl text-zinc-500">Logged in</h1>
                @else
                    @include("auth.login")
                @endauth
            </div>
        </div>
    </body>
</html>
