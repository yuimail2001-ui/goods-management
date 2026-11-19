<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradingCard;
use App\Http\Requests\StoreTradingCardRequest;
use App\Http\Requests\UpdateTradingCardRequest;
use Illuminate\Support\Facades\Storage;

class TradingCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tradingCards = TradingCard::all();
        return response()->json($tradingCards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTradingCardRequest $request)
    {
        $data = $request->validated();
        unset($data['image']);

        $data['owned_count'] = $data['owned_count'] ?? 0;
        $data['possession_status'] = $data['owned_count'] > 0 ? 'owned' : 'not_owned';
        $data['card_code'] = $this->generateCardCode($data['tour_id']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('trading_card_images', 'public');
        }

        $tradingCard = TradingCard::create($data);
        return response()->json($tradingCard, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tradingCard = TradingCard::findOrFail($id);
        return response()->json($tradingCard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTradingCardRequest $request, string $id)
    {
        $tradingCard = TradingCard::findOrFail($id);

        $data = $request->validated();
        unset($data['image']);
        unset($data['card_code']);

        $data['owned_count'] = $data['owned_count'] ?? $tradingCard->owned_count;
        $data['possession_status'] = $data['owned_count'] > 0 ? 'owned' : 'not_owned';

        if ($request->hasFile('image')) {
            if ($tradingCard->image_path) {
                Storage::disk('public')->delete($tradingCard->image_path);
            }
            $data['image_path'] = $request->file('image')->store('trading_card_images', 'public');
        }

        $tradingCard->update($data);
        return response()->json($tradingCard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tradingCard = TradingCard::findOrFail($id);
        $tradingCard->delete();
        return response()->json(null, 204);
    }

    /**
     * ツアーごとの連番でカードIDを自動生成する(例: T21-001)
     */
    private function generateCardCode(int $tourId): string
    {
        $count = TradingCard::withTrashed()->where('tour_id', $tourId)->count();
        $sequence = str_pad((string) ($count + 1), 3, '0', STR_PAD_LEFT);

        return "T{$tourId}-{$sequence}";
    }
}
