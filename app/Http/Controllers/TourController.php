<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest; 
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::all();

        return response()->json($tours);
    }

    /**
     * Store a newly created resource in storage.
     * 登録処理
     */
    public function store(StoreTourRequest $request)
    {
        $tour = Tour::create($request->validated());

        return response()->json($tour, 201);
    }

    /**
     * Display the specified resource.
     * 詳細表示
     */
    public function show(string $id)
    {
        $tour = Tour::findOrFail($id);

        return response()->json($tour);
    }

    /**
     * Update the specified resource in storage.
     * 更新処理
     */
    public function update(UpdateTourRequest $request, string $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->update($request->validated());

        return response()->json($tour);
    }

    /**
     * Remove the specified resource from storage.
     * 削除処理
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return response()->json(null, 204);
    }
}
