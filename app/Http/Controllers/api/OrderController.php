<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', '=', $user->id)->with('product')->get();

        $data = $orders->map(function ($order) {
            $product = $order->product;
            return [
                "product_name" => $product->name,
                "product_image" => $product->image,
                "delivered_at" => $order->delivered_at,
                "order_id" => $order->id,
            ];
        });

        return response()->json(["data" => $data], 200);
    }

    public function placeOrder()
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();

        // Loop through the cart items and create orders
        foreach ($carts as $cart) {
            $order = new Order();
            $order->count = $cart->count;
            $order->total = $cart->total;
            $order->user_id = $user->id;
            $order->delivered_at = now();
            $order->save();

            // Create an order_product entry
            $orderProduct = new Order_Product();
            $orderProduct->count = $cart->count;
            $orderProduct->total = $cart->total;
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cart->product->id;
            $orderProduct->save();

            // Remove the cart entry as the product is ordered
            $cart->delete();
        }

        return response()->json(["message" => "Order placed successfully"], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
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
