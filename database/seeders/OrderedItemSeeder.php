<?php

namespace Database\Seeders;

use App\Models\OrderedItem;
use Illuminate\Database\Seeder;

class OrderedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderedItems = OrderedItem::factory(50)->create();
    }
}
