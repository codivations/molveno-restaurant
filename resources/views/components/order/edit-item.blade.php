@props([
    "index",
    "tableNumber",
    "item",
])

<form
    class="flex items-center justify-between rounded-md"
    method="post"
    action="{{ route("order.updateOrder", ["tableNumber" => $tableNumber]) }}"
>
    @method("PATCH")
    @csrf
    <div class="flex w-1/2 flex-col gap-3">
        <input type="hidden" name="tableNumber" value="{{ $tableNumber }}" />
        <input type="hidden" name="index" value="{{ $index }}" />
        <label class="max-w-max">
            <input
                type="checkbox"
                class="rounded-full"
                name="dietary_restrictions"
                @checked($item["dietary_restrictions"])
            />
            Allergies
        </label>
        <textarea name="notes" placeholder="Special notes" maxlength="255">
{{ $item["notes"] }}</textarea
        >
    </div>
    <div class="self-start">
        <button
            type="submit"
            class="h-8 rounded-full border border-black bg-green-500 px-2"
        >
            submit
        </button>
    </div>
</form>
