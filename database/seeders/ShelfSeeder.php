<?php

namespace Database\Seeders;

use App\Enums\BookGenreEnum;
use App\Enums\ShelveRowsEnum;
use App\Models\Shelf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $number) {
            $rows = ['1', '2', '3', '4', '5'];

            $shelves[] = [
                'number' => $number,
                'rows' => $rows,
            ];
        }

        foreach ($shelves as $shelf) {
            Shelf::create($shelf);
        }

    }
}
