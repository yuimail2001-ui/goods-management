<?php

namespace Database\Seeders;

use App\Models\TradingCard;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class TradingCardSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $frozenBond = Tour::where('name', '氷結の絆 -Frozen Bond-')->firstOrFail();
        $starlight = Tour::where('name', 'STARLIGHT PARADE')->firstOrFail();

        TradingCard::create([
            'card_code' => 'FB-001',
            'member_name' => '花音',
            'tour_id' => $frozenBond->id,
            'possession_status' => 'owned',
            'owned_count' => 2,
            'description' => '氷結の絆 限定カード',
        ]);

        TradingCard::create([
            'card_code' => 'FB-002',
            'member_name' => '美咲',
            'tour_id' => $frozenBond->id,
            'possession_status' => 'not_owned',
            'owned_count' => 0,
            'description' => '氷結の絆 限定カード',
        ]);

        TradingCard::create([
            'card_code' => 'FB-003',
            'member_name' => '涼子',
            'tour_id' => $frozenBond->id,
            'possession_status' => 'owned',
            'owned_count' => 1,
            'description' => null,
        ]);

        TradingCard::create([
            'card_code' => 'SP-001',
            'member_name' => '花音',
            'tour_id' => $starlight->id,
            'possession_status' => 'owned',
            'owned_count' => 3,
            'description' => 'STARLIGHT PARADE 限定カード',
        ]);

        TradingCard::create([
            'card_code' => 'SP-002',
            'member_name' => '美咲',
            'tour_id' => $starlight->id,
            'possession_status' => 'not_owned',
            'owned_count' => 0,
            'description' => 'STARLIGHT PARADE 限定カード',
        ]);
    }
}
