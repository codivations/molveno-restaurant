<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(OrderSeeder::class);

        $orderedItems = OrderedItem::factory(50)->create();
    }
}
