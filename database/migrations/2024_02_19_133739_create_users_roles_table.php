<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * References:
     * https://laravel.com/docs/10.x/migrations#creating-indexes
     * https://laravel.com/docs/10.x/migrations#foreign-key-constraints
     */
    public function up(): void
    {
        Schema::create("users_roles", function (Blueprint $table) {
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("role_id");
            $table->timestamps();

            $table->primary(["user_id", "role_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("users_roles");
    }
};
