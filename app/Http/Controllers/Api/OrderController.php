<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  $orders = Order::all();
        // return response()->json(compact("orders"), 200);

        $orders = Order::with('customer','status')->get();
        return response()->json([
            'orders'=>$orders

        ]);
    }


    public function invoice($id)
    {
        $order = Order::find($id);
        $order_details = OrderDetail::with('product')->where("order_id", "=", $id)->get();
        $customer = Customer::find($order->customer_id);
        return response()->json(compact("order", "order_details", "customer"));
    }

        public function orderData()
    {
        $products = Product::all();
        $customers = Customer::all();
        return response()->json(compact("products", "customers"));
    }


     public function react_order_save(Request $request)
    {



        try {

            $order = new Order();
            $order->customer_id = $request->customer['id'];
            $order->total =$request->summary['total'];
            $order->paid =$request->summary['total'];
            $order->status_id=1;
            $order->delivery_date = now();
            $order->delivery_address = $request->customer['address'];

            $order->save();


            foreach ($request->cartItems as $key => $value) {
                $order_details = new OrderDetail();
                $order_details->order_id = $order->id;
                $order_details->product_id = $value['id'];
                $order_details->quantity = $value['quantity'];
                $order_details->price = $value['price'];
                $order_details->discount = $value['discount'];
                $order_details->save();

                $stock= new Stock();
                $stock->product_id= $value['id'];
                $stock->quantity= $value['quantity'] *-1;
                $stock->transaction_type_id=1;
                $stock->warehouse_id=1;

                $stock->save();
            }
            return response()->json(["success"=> "Order Created Successfully"]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }




    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
