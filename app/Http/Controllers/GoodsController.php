<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoodsRequest;
use App\Http\Requests\UpdateGoodsRequest;
use App\Models\Goods;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goods = Goods::all();

        return response()->json($goods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoodsRequest $request)
    {
        $goods = Goods::create($request->validated());

        return response()->json($goods, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $goods = Goods::findOrFail($id);

        return response()->json($goods);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoodsRequest $request, string $id)
    {
        $goods = Goods::findOrFail($id);
        $goods->update($request->validated());

        return response()->json($goods);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $goods = Goods::findOrFail($id);
        $goods->delete();

        return response()->json(null, 204);
    }
}
