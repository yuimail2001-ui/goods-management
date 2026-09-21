<?php

namespace Database\Seeders;

use App\Models\Goods;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class GoodsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $frozenBond = Tour::where('name', '氷結の絆 -Frozen Bond-')->firstOrFail();
        $starlight = Tour::where('name', 'STARLIGHT PARADE')->firstOrFail();

        Goods::create([
            'tour_id' => $frozenBond->id,
            'name' => 'アクリルスタンド',
            'category' => 'グッズ',
            'price' => 1800,
        ]);

        Goods::create([
            'tour_id' => $frozenBond->id,
            'name' => 'Tシャツ -Frozen Bond ver.-',
            'category' => 'アパレル',
            'price' => 4500,
        ]);

        Goods::create([
            'tour_id' => $frozenBond->id,
            'name' => 'ペンライト',
            'category' => 'グッズ',
            'price' => 3200,
        ]);

        Goods::create([
            'tour_id' => $frozenBond->id,
            'name' => 'トレーディング缶バッジ',
            'category' => 'グッズ',
            'price' => 800,
        ]);

        Goods::create([
            'tour_id' => $starlight->id,
            'name' => 'STARLIGHT タオル',
            'category' => 'グッズ',
            'price' => 2500,
        ]);

        Goods::create([
            'tour_id' => $starlight->id,
            'name' => 'パーカー -Neon ver.-',
            'category' => 'アパレル',
            'price' => 6800,
        ]);
    }
}
