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
        Schema::create("orders_items", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("order_id");
            $table->enum("status", ["to do", "in progress", "ready", "done"]);
            $table->foreignId("menu_item_id");
            $table->boolean("dietary_restrictions")->default(false);
            $table->text("notes");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders_items");
    }
};
