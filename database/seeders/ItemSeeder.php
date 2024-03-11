<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(MenuSeeder::class);

        $items = Item::factory(50)->create();

        foreach ($items as $item) {
            $randomId = fake()->numberBetween(1, 3);
            $item->menus()->attach($randomId);
        }
    }
}
