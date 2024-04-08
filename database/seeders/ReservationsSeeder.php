<?php

namespace Database\Seeders;

use App\Models\Reservations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservations::factory()
            ->times(50)
            ->create();
    }
}
