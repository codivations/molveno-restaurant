<div
    class="flex min-h-screen flex-col items-center justify-center bg-gray-100 sm:pt-0 dark:bg-gray-900"
>
    <div>
        <a href="/">
            <x-application-logo />
        </a>
    </div>

    <div
        class="mt-6 overflow-hidden bg-white px-6 py-4 shadow-md sm:w-full sm:max-w-md sm:rounded-lg dark:bg-gray-800"
    >
        {{ $slot }}
    </div>
</div>
