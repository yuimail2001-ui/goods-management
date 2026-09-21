<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tour::create([
            'name' => '氷結の絆 -Frozen Bond-',
            'start_date' => '2026-01-10',
            'end_date' => '2026-01-12',
        ]);

        Tour::create([
            'name' => 'STARLIGHT PARADE',
            'start_date' => '2026-02-14',
            'end_date' => '2026-02-16',
        ]);

        Tour::create([
            'name' => 'サクラフェスティバル',
            'start_date' => '2026-03-20',
            'end_date' => '2026-03-22',
        ]);

        Tour::create([
            'name' => 'Neon Dream Tour 2026',
            'start_date' => '2026-04-05',
            'end_date' => '2026-04-07',
        ]);

        Tour::create([
            'name' => 'ミッドナイトブルー',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-03',
        ]);
    }
}
