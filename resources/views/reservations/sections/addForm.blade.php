<form class="h-full w-full" action="/reservations/create" method="POST">
    <div class="flex h-full flex-col justify-between">
        <div class="container m-5 mx-auto w-2/3">
            <div class="text-center text-4xl">New Reservation</div>
            @include("reservations.sections.form")
        </div>
        <div class="bottom-bar">
            <div class="button-row">
                <input type="submit" value="confirm" class="button" />
                <a class="button" href="/reservations">Cancel</a>
            </div>
        </div>
    </div>
</form>
