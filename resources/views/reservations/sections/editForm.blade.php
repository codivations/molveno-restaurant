<div
    class="flex h-full flex-col justify-between"
    x-data="{ modalOpen: false }"
>
    <div>
        <form
            action="/reservations/editReservation/id/{{ $selectedReservation->id }}"
            method="POST"
        >
            <div class="container m-5 mx-auto w-2/3">
                <div class="text-center text-4xl">Edit Reservation</div>
                @include("reservations.sections.form")
            </div>
            <div class="hidden">
                <label for="table" class="form-label">#</label>
                <input
                    type="hidden"
                    name="id"
                    value="{{ $selectedReservation->id }}"
                />
            </div>
            <div class="modal" x-show="modalOpen">
                <div class="dialog-box">
                    <div class="dialog-text w-fit text-center">
                        Are you certain you want to edit this reservation?
                    </div>
                    <div class="button-row">
                        <button
                            class="button"
                            x-on:click="modalOpen = ! modalOpen"
                        >
                            Cancel
                        </button>
                        <form
                            method="POST"
                            action="{{ route("reservations.delete", ["id" => $selectedReservation->id]) }}"
                        >
                            @csrf
                            <input
                                type="hidden"
                                name="id"
                                value="{{ $selectedReservation->id }}"
                            />
                            <button class="button">Submit edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bottom-bar">
        <div class="button-row">
            <button class="button" x-on:click="modalOpen = ! modalOpen">
                Confirm
            </button>
            <a
                class="button"
                href="/reservations/id/{{ $selectedReservation->id }}"
            >
                Cancel
            </a>
        </div>
    </div>

    @error("id")
        <div
            class="modal"
            x-data="{ errorOpen: true }"
            x-show="errorOpen"
        >
            <div class="dialog-box">
                <div class="dialog-text w-fit text-center">
                    Failed to edit selected reservation! ID invalid! Reservation
                    not found in database
                </div>
                <div class="button-row">
                    <button
                        class="button"
                        x-on:click="errorOpen = ! errorOpen"
                    >
                        Ok
                    </button>
                </div>
            </div>
        </div>
    @enderror
</div>
