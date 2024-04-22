<form
    action="/reservations/edit/id/{{ $selectedReservation->id }}"
    method="POST"
    class="container m-5 mx-auto w-2/3"
>
    @include("reservations.sections.form")
    <div class="hidden">
        <label for="table" class="form-label">#</label>
        <input
            type="hidden"
            name="id"
            value="{{ $selectedReservation->id }}"
        />
    </div>
    <div>
        <input type="submit" value="confirm edit" class="button" />
    </div>
</form>
