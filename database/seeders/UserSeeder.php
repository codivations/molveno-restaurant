<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //region roles
        $adminRole = Role::factory()->create([
            "name" => "admin",
        ]);

        $chefRole = Role::factory()->create([
            "name" => "chef",
        ]);

        $waitstaffRole = Role::factory()->create([
            "name" => "waitstaff",
        ]);

        $kitchenRole = Role::factory()->create([
            "name" => "kitchen",
        ]);
        //endregion

        //region users
        User::factory()
            ->create([
                "name" => "Admin",
                "password" => "123456",
                "login_name" => "admin",
            ])
            ->roles()
            ->attach($adminRole->id);

        User::factory()
            ->create([
                "name" => "Kitchen Staff",
                "password" => "111111",
                "login_name" => "kitchen",
            ])
            ->roles()
            ->attach($kitchenRole->id);

        User::factory()
            ->create([
                "name" => "Wait Staff",
                "password" => "222222",
                "login_name" => "waiter",
            ])
            ->roles()
            ->attach($waitstaffRole->id);

        User::factory()
            ->create([
                "name" => "Sous Chef",
                "password" => "000000",
                "login_name" => "souschef",
            ])
            ->roles()
            ->attach($chefRole->id);

        User::factory()
            ->create([
                "name" => "Vivian",
                "password" => "111111",
                "login_name" => "vivian",
            ])
            ->roles()
            ->attach($waitstaffRole->id);

        User::factory()
            ->create([
                "name" => "Jeroen",
                "password" => "111111",
                "login_name" => "jeroen",
            ])
            ->roles()
            ->attach($waitstaffRole->id);
        //endregion
    }
}
