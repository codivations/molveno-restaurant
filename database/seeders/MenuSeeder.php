<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Enums\MenuService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory()->create(["service" => MenuService::BREAKFAST]);
        Menu::factory()->create(["service" => MenuService::LUNCH]);
        Menu::factory()->create(["service" => MenuService::DINNER]);
    }
}
