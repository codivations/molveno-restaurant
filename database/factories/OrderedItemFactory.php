<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderedItem>
 */
class OrderedItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order_id" => fake()->numberBetween(1, 10),
            "status" => OrderStatus::TO_DO->value,
            "menu_item_id" => fake()->numberBetween(1, 50),
            "dietary_restrictions" => fake()->boolean(10),
            "notes" => fake()
                ->optional($weight = 0.5)
                ->sentence(),
        ];
    }
}
