<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        $carts = Cart::where('user_id', '=', $user->id)->whereHas('product', function ($query) {
            $query->whereColumn('category_id', 'products.category_id');
        })->with('product')->get();
        // dd($carts);
        // Group the products by category
        $groupedProducts = $carts->groupBy(function ($cart) {
            return $cart->product->category->title;
        });
        // Create an array to hold the final data
        $data = [];
        foreach ($groupedProducts as $categoryTitle => $cartsInCategory) {
            $categoryData = [
                'category' => $categoryTitle,
                'products' => $cartsInCategory->map(function ($cart) {
                    $product = $cart->product;
                    return [
                        "id" => $cart->id,
                        "name" => $product->name,
                        "price" => $product->price,
                        "image" => $product->image,
                        "count" => $cart->count,
                        "total" => $cart->total,
                    ];
                }),
            ];
            $data[] = $categoryData;
        }
        $totalCartPrice = $carts->sum('total');
        return response()->json([
            "data" => $data,
            "totalCartPrice" => $totalCartPrice,
        ], 200);
    }

    public function addToCart(Request $request, $favoriteId)
    {
        $user = auth()->user();
        $favorite = Favourite::with('product')->findOrFail($favoriteId);
        // Calculate the total
        $total = $favorite->product->price * $favorite->count;
        // dd($request);
        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $favorite->product->id)
            ->first();
        if ($existingCartItem) {
            $existingCartItem->count += $request->count;
            $existingCartItem->total += $total;
            $existingCartItem->save();
        } else {
            // Create a new cart entry
            $cart = new Cart();
            $cart->count = $request->count;
            // $cart->count = $favorite->count;
            $cart->total = $total;
            $cart->user_id = $user->id;
            $cart->product_id = $favorite->product->id;
            $cart->save();
        }

        return response()->json(["message" => "Product added to cart successfully"], 200);
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
    public function destroy(Cart $cart)
    {
        //
        $isDeleted = $cart->delete();

        return response()->json([
            "message" => $isDeleted ? "Product removed from cart successfully"
                :
                'Failed to remove product',
            $isDeleted ?
                Response::HTTP_NO_CONTENT :
                Response::HTTP_BAD_REQUEST
        ], 204);
    }
}
