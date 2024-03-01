<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            "name" => "admin",
        ]);

        Role::factory()->create([
            "name" => "chef",
        ]);

        Role::factory()->create([
            "name" => "waitstaff",
        ]);

        Role::factory()->create([
            "name" => "kitchen",
        ]);
    }
}
