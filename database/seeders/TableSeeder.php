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
            } elseif ($i > 7) {
                $area = SeatingArea::FIRSTFLOOR;
            } else {
                $area = SeatingArea::GROUNDFLOOR;
            }

            Table::factory()->create();
        }
    }
}
