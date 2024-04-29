<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Enums\SeatingArea;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableCapacity = [
            2,
            2,
            4,
            4,
            4,
            6,
            2,
            2,
            2,
            4,
            4,
            4,
            4,
            6,
            6,
            2,
            2,
            2,
            2,
            2,
            4,
            4,
            4,
            4,
            4,
            4,
            4,
            4,
            4,
            6,
            6,
        ];

        for ($i = 0; $i < count($tableCapacity); $i++) {
            if ($i > 14) {
                $area = SeatingArea::TERRACE;
            } elseif ($i > 5) {
                $area = SeatingArea::FIRSTFLOOR;
            } else {
                $area = SeatingArea::GROUNDFLOOR;
            }

            $seated =
                $i <= 3 || ($i > 6 && $i <= 8) || ($i > 14 && $i <= 18)
                    ? $i + 1
                    : null;

            Table::factory()->create([
                "table_number" => $i + 1,
                "seating_area" => $area,
                "seated_reservation" => $seated,
                "capacity" => $tableCapacity[$i],
            ]);
        }
    }
}
