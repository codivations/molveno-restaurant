<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\reservations>
 */
class ReservationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween("+0 days", "+3 days");

        $service = $this->faker->randomElement([
            "breakfast",
            "lunch",
            "dinner",
        ]);
        switch ($service) {
            case "breakfast":
                date_time_set($startTime, 9, 30);
                $reservationTime = $this->faker->dateTimeInInterval(
                    $startTime,
                    "1 hours"
                );
                break;
            case "lunch":
                date_time_set($startTime, 12, 0);
                $reservationTime = $this->faker->dateTimeInInterval(
                    $startTime,
                    "2 hours"
                );
                break;
            default:
                //dinner
                date_time_set($startTime, 18, 0);
                $reservationTime = $this->faker->dateTimeInInterval(
                    $startTime,
                    "3 hours"
                );
                break;
        }

        $partySize = $this->faker
            ->optional(0.2, $this->faker->numberBetween(2, 6))
            ->numberBetween(7, 12);
        $tableSize = 2;

        return [
            "name" => fake()->lastName(),
            "party_size" => $partySize,
            "phone_number" => fake()->phoneNumber(),
            "reservation_time" => $reservationTime,
            "service" => $service,
            "hotel_room" => fake()
                ->optional(0.7)
                ->numberBetween(1, 99),
            "seating_area" => fake()->randomElement([
                "terrace",
                "ground floor",
                "first floor",
            ]),
            "table_amount" => ceil($partySize / $tableSize),
            "high_chair_amount" => fake()
                ->optional(0.1, 0)
                ->numberBetween(0, 2),
            "booster_seat_amount" => fake()
                ->optional(0.15, 0)
                ->numberBetween(0, 3),
            "dietary_restrictions" => fake()->boolean(),
            "notes" => fake()->text(),
        ];
    }
}
