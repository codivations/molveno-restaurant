<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "status" => OrderStatus::TO_DO->value,
            "reservation_id" => fake()->numberBetween(1, 20),
            "staff_id" => fake()->numberBetween(5, 6),
        ];
    }
}
