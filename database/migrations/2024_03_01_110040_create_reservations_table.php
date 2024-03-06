<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("reservations", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->integer("party_size");
            $table->string("phone_number")->nullable();
            $table->dateTime("reservation_time");
            $table
                ->string("hotel_room")
                ->nullable()
                ->default(null);
            $table->enum("seating_area", [
                "terrace",
                "ground floor",
                "first floor",
            ]);
            $table->integer("table_amount")->default(1);
            $table->integer("high_chair_amount")->default(0);
            $table->integer("booster_seat_amount")->default(0);
            $table->boolean("dietary_restrictions")->default(false);
            $table->text("notes")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("reservations");
    }
};
