<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "Admin",
            "password" => "123456",
            "login_name" => "admin",
        ]);

        User::factory()->create([
            "name" => "Kitchen Staff",
            "password" => "111111",
            "login_name" => "kitchen",
        ]);

        User::factory()->create([
            "name" => "Wait Staff",
            "password" => "222222",
            "login_name" => "waiter",
        ]);

        User::factory()->create([
            "name" => "Reception Staff",
            "password" => "000000",
            "login_name" => "reception",
        ]);

        User::factory()
            ->count(10)
            ->create();
    }
}
