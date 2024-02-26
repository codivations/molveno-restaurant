<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                "name" => "Admin",
                "password" => "123456",
                "login_name" => "admin",
            ])
            ->roles()
            ->attach(1);

        User::factory()
            ->create([
                "name" => "Kitchen Staff",
                "password" => "111111",
                "login_name" => "kitchen",
            ])
            ->roles()
            ->attach(4);

        User::factory()
            ->create([
                "name" => "Wait Staff",
                "password" => "222222",
                "login_name" => "waiter",
            ])
            ->roles()
            ->attach(3);

        User::factory()
            ->create([
                "name" => "Sous Chef",
                "password" => "000000",
                "login_name" => "souschef",
            ])
            ->roles()
            ->attach(2);
    }
}
