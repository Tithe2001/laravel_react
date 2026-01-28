<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier','status')->get();
        return response()->json([
            'purchases'=>$purchases

        ]);
    }


public function invoice($id)
{
    $purchase = Purchase::with([
        'supplier',
        'details.product'
    ])->findOrFail($id);

    return response()->json([
        'purchase' => $purchase,
        'purchase_details' => $purchase->details,
        'supplier' => $purchase->supplier
    ]);
}





public function purchaseData()
{
    $products = Product::all();
    $suppliers = Supplier::all();

    return response()->json(compact('products', 'suppliers'));
}




public function react_purchase_save(Request $request)
{
    try {
        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier['id'];
        $purchase->total = $request->summary['total'];
        $purchase->paid = $request->summary['total']; // you don’t send paid separately
        $purchase->status_id = 1;
        $purchase->save();

        foreach ($request->cartItems as $value) {

            $purchase_detail = new PurchaseDetail();
            $purchase_detail->purchase_id = $purchase->id;
            $purchase_detail->product_id = $value['id'];
            $purchase_detail->quantity = $value['quantity'];

            // ✅ FIX HERE
            $purchase_detail->unit_price = $value['price'];

            $purchase_detail->discount = $value['discount'];
            $purchase_detail->save();

            // Stock update
            Stock::create([
                'product_id' => $value['id'],
                'quantity' => $value['quantity'],
                'transaction_type_id' => 2,
                'warehouse_id' => 1,
            ]);
        }

        return response()->json(['success' => 'Purchase Created Successfully']);

    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
}




      public function find($id)
    {
        $purchase = Purchase::with('details.product')->findOrFail($id);
        return response()->json(['purchase' => $purchase]);
    }



    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
     public function delete(Request $request)
    {
        PurchaseDetail::where('purchase_id',$request->id)->delete();
        Purchase::where('id',$request->id)->delete();
        return response()->json(['success'=>'Purchase deleted successfully']);
    }



}
