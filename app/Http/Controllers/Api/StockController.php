<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{

    // public function index()
    // {
    //     $stocks = Stock::with('product')->get();
    //     return response()->json([
    //         'stocks'=>$stocks

    //     ]);
    // }


    public function index()
{
    $stocks = Stock::selectRaw('product_id, SUM(quantity) as total_quantity')
        ->with('product')
        ->groupBy('product_id')
        ->get();

    return response()->json([
        'stocks' => $stocks
    ]);
}

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
