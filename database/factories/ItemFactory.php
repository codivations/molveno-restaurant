<?php

namespace Database\Factories;

use App\Enums\ItemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()
                ->unique()
                ->word(),
            "description" => fake()
                ->optional($weight = 0.3)
                ->sentence(),
            "price" => fake()->numberBetween(500, 5000),
            "category" => fake()->randomElement(ItemCategory::class),
        ];
    }
}
