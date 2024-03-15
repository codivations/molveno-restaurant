<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
|--------------------------------------------------------------------------
| AllowAccessForRoles Middleware
|--------------------------------------------------------------------------
|
| To use this middleware add `role:roleName|otherRoleName|etc` to the array of middleware
| you don't need to specify the admin role
| if this is an page only an admin should access you can just use `role`
|
| Example with specific roles: ->middleware(["auth", "verified", "role:chef|kitchen"])
|
| Example admin only: ->middleware(["auth", "verified", "role"])
|
*/

Route::get("/", function () {
    return view("welcome");
});

Route::get("/dashboard", function () {
    return view("dashboard");
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );
});

Route::get("/reservations", [
    ReservationsController::class,
    "showUnfilteredOverview",
]);
Route::get("/reservations/new", [ReservationsController::class, "showForm"]);
Route::post("/reservations", [
    ReservationsController::class,
    "showFilteredOverview",
]);

Route::get("/reservationForm", [ReservationsController::class, "show"]);
Route::post("/reservations/create", [ReservationsController::class, "store"]);

Route::get("/reservations/{id}", [
    ReservationsController::class,
    "showReservation",
]);

require __DIR__ . "/auth.php";
