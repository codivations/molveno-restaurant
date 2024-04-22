@props([
    "tableNumber",
])

@foreach (session("order")->items as $item)
    <article>
        <div
            class="flex justify-between rounded-md border border-black bg-white p-4"
        >
            <div class="w-2/3">
                <div class="flex justify-between">
                    <h2 class="text-2xl font-bold first-letter:capitalize">
                        {{ $item["item_name"] }}
                    </h2>
                    <p>
                        {{ $item["price"] }}
                    </p>
                </div>
                <div>
                    {{ $item["dietary_restrictions"] ? "Has allergy" : "" }}
                </div>
                @if ($item["notes"])
                    <div>Notes:</div>
                    <div class="rounded-md border border-black bg-gray-300 p-2">
                        {{ $item["notes"] }}
                    </div>
                @endif
            </div>

            <button
                @click="edit_open = edit_open == {{ $loop->index }} ? null : {{ $loop->index }}"
                class="button h-8 w-16 self-center p-0"
            >
                edit
            </button>
        </div>
        <div
            x-show="edit_open == {{ $loop->index }}"
            class="flex flex-col rounded-md border border-black bg-white p-4"
        >
            <x-order.edit-item
                :index="$loop->index"
                :tableNumber="$tableNumber"
                :item="$item"
            />

            <form
                class="self-end"
                method="POST"
                action="{{ route("order.removeFromOrder", ["tableNumber" => $tableNumber]) }}"
            >
                @csrf
                @method("DELETE")
                <input
                    type="hidden"
                    name="tableNumber"
                    value="{{ $tableNumber }}"
                />
                <input type="hidden" name="index" value="{{ $loop->index }}" />
                <button
                    type="submit"
                    class="h-8 rounded-full border border-black bg-red-600 px-2"
                >
                    Delete
                </button>
            </form>
        </div>
    </article>
@endforeach
