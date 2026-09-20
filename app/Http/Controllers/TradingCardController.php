<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradingCard;
use App\Http\Requests\StoreTradingCardRequest;
use App\Http\Requests\UpdateTradingCardRequest;

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
        $tradingCard = TradingCard::create($request->validated());
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
        $tradingCard->update($request->validated());
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
}
