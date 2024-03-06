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
        Schema::create("menus_items", function (Blueprint $table) {
            $table
                ->foreignId("menu_id")
                ->constrained(table: "menus", indexName: "menus_items_menu_id");
            $table
                ->foreignId("item_id")
                ->constrained(table: "items", indexName: "menus_items_item_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("menus_items");
    }
};
