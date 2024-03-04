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
        Schema::create("reservations_tables", function (Blueprint $table) {
            $table->unsignedBigInteger("table_id");

            $table
                ->foreign("table_id")
                ->references("id")
                ->on("tables");

            $table->unsignedBigInteger("reservation_id");

            $table
                ->foreign("reservation_id")
                ->references("id")
                ->on("reservations");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("reservations_tables");
    }
};
