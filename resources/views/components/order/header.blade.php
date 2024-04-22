@props([
    "tableNumber",
])

<header
    class="sticky top-0 flex items-center justify-between rounded-b-lg border-x border-b border-black bg-white p-4"
>
    <h1 class="text-3xl font-bold underline">Table {{ $tableNumber }}</h1>
    <div class="flex gap-2 text-sm font-bold">
        <a href="/order/{{ $tableNumber }}/drinks" class="button h-8 w-16">
            Add
        </a>
        <form
            method="POST"
            action="{{ route("order.sendToKitchen", ["tableNumber" => $tableNumber]) }}"
        >
            @csrf
            <button type="submit" class="button h-8 w-16 bg-green-500">
                Send
            </button>
        </form>
    </div>
</header>
