<?php

use App\Http\Controllers\MenuOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\TablesController;
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

Route::name("reservations.")
    ->middleware(["auth"])
    ->group(function () {
        Route::get("/reservations", [
            ReservationsController::class,
            "showUnfilteredOverview",
        ])->name("index");
        Route::get("/reservations/new", [
            ReservationsController::class,
            "showForm",
        ]);
        Route::post("/reservations", [
            ReservationsController::class,
            "showFilteredOverview",
        ]);
        Route::post("/reservations/create", [
            ReservationsController::class,
            "store",
        ]);
        Route::get("/reservations/id/{id}", [
            ReservationsController::class,
            "showReservation",
        ]);
        Route::get("/reservations/delete/id/{id}", [
            ReservationsController::class,
            "deleteReservation",
        ])->name("delete");
    });

Route::name("kitchen.")
    ->middleware(["auth"])
    ->group(function () {
        Route::get("/kitchen", [KitchenController::class, "show"]);
    });

Route::name("order.")
    ->middleware(["auth", "role:waitstaff"])
    ->group(function () {
        Route::get("/order", [MenuOrderController::class, "index"])->name(
            "index"
        );
        Route::get("/order/{tableNumber}", [
            MenuOrderController::class,
            "showMenu",
        ]);
        Route::get("/order/{tableNumber}/showOrder", [
            MenuOrderController::class,
            "showOrder",
        ])->name("showOrder");
        Route::post("/order/{tableNumber}/showOrder", [
            MenuOrderController::class,
            "sendOrder",
        ]);
        Route::get("/order/{tableNumber}/{service}", [
            MenuOrderController::class,
            "showService",
        ])->name("showService");
        Route::post("/order/{tableNumber}/{service}", [
            MenuOrderController::class,
            "addToOrder",
        ]);
    });

Route::name("tables.")
    ->middleware(["auth"])
    ->group(function () {
        Route::get("/tables", [TablesController::class, "show"])->name("all");
        Route::get("/tables/{area}/{seated}", [
            TablesController::class,
            "show",
        ])->name("filtered");
        Route::post("tables/seat", [TablesController::class, "seat"]);
        Route::post("tables/unseat", [TablesController::class, "unseat"]);
    });

require __DIR__ . "/auth.php";
