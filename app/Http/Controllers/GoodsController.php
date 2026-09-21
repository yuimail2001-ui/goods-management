<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGoodsRequest;
use App\Http\Requests\UpdateGoodsRequest;
use App\Models\Tour;
use App\Models\Goods;
use Illuminate\Support\Facades\Storage;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goods = Goods::when($request->query('tour_id'), function ($query, $tourId) {
            return $query->where('tour_id', $tourId);
        })->get();

        return response()->json($goods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoodsRequest $request)
    {
        $tourId = $request->input('tour_id');

        // ツアー新規登録
        if(!$tourId) {
            $tour = Tour::create([
                'name' => $request->new_tour_name,
                'start_date' => $request->new_tour_start_date,
                'end_date' => $request->new_tour_end_date,
            ]);
            // 新規登録したツアーID取得
            $tourId = $tour->id;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('goods_images', 'public');
        }
        $goods = Goods::create([
            'image_path' => $imagePath, 
            'tour_id' => $tourId,
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'purchase_status' => $request->input('purchase_status'),
            'purchased_at' => $request->input('purchased_at'),
            'description' => $request->input('description')
        ]);

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

        $data = $request->validated();
        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($goods->image_path) {
                Storage::disk('public')->delete($goods->image_path);
            }
            $data['image_path'] = $request->file('image')->store('goods_images', 'public');
        }

        $goods->update($data);

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
