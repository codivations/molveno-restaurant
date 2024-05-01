<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ReservationsSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            OrderSeeder::class,
            OrderedItemSeeder::class,
            TableSeeder::class,
        ]);
    }
}
