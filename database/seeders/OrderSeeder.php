<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Models\OrderedItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->times(10)
            ->create();
    }
}
