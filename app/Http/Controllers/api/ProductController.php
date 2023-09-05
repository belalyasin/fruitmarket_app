<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NutritionResources;
use App\Models\Cart;
use App\Models\Favourite;
use App\Models\Nutrition;
use App\Models\Product;
use App\Models\Product_Nutrition;
use App\Models\Rate;
use App\Models\Sub_Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with(['category', 'product_nutrition','rates'])->get();
        $data = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                // "rate" => $product->rate,
                'average_rating' => $product->average_rating,
                "description" => $product->description,
                "image" => $product->image,
                "isFavorite" => (bool)$product->isFavorite,
                "sub_category" => $product->category ? $product->category->title : null,
                'nutrition' => NutritionResources::collection(
                    Nutrition::whereIn('id', $product->product_nutrition->pluck('nutrition_id'))->get()
                ),
            ];
        });
        return response()->json(["data" => $data], status: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $favoriteId)
    {
        //
        $user = auth()->user();
        $favorite = Favourite::with('products')->findOrFail($favoriteId);

        // Calculate the total
        $total = $favorite->products->price * $favorite->count;

        // Create a new cart entry
        $cart = new Cart();
        $cart->count = $favorite->count;
        $cart->total = $total;
        $cart->user_id = $user->id;
        $cart->product_id = $favorite->products->id;
        $cart->save();

        return response()->json(["message" => "Product added to cart successfully"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        // $product = Product::with('rates')->findOrFail($product->id);
        $data = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            // "rate" => $product->rate,
            'average_rating' => $product->average_rating,
            "description" => $product->description,
            "image" => $product->image,
            "isFavorite" => (bool)$product->isFavorite,
            "sub_category" => $product->category ? $product->category->title : null,
            'nutrition' => NutritionResources::collection(
                Nutrition::whereIn('id', $product->product_nutrition->pluck('nutrition_id'))->get()
            ),
        ];

        return response()->json([$data], status: 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        $user = auth()->user();
        $product = Product::where('id', '=', $product->id)->first();
        // $product = Product::findOrFail($product->id);
        // dd($product->id);
        $response = strtolower($request->isFavorite);
        if ($response === 'true') {
            // Check if the favorite record already exists
            // dd($request->isFavorite === 'true');
            // $existingFavorite = Favourite::where('user_id', '=', $user->id)
            //     ->where('product_id', $product->id)
            //     ->first();
            // dd($existingFavorite);

            // if (!$existingFavorite) {
            // Create a new favorite record
            $favorite = new Favourite();
            $favorite->count = 1;
            $favorite->user_id = $user->id;
            $favorite->product_id = $product->id;
            $favorite->save();
            // }
        } else if ($response === 'false') {
            // Delete the favorite record if it exists
            // dd($request);
            Favourite::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->delete();
        }
        $product->isFavorite = $request->isFavorite === 'true' ? 1 : 0; //true
        $product->save();
        return response()->json(['message' => 'Favorite status updated']);
    }

    public function rateProduct(Request $request, Product $product)
    {
        $user = auth()->user();
        $product = Product::where('id', '=', $product->id)->first();
        $rate = new Rate();
        $rate->rate = $request->rate;
        $rate->user_id = $user->id;
        $rate->product_id = $product->id;
        $rate->save();
        $product->rate = $product->rates->avg('rate');
        $product->save();
        return response()->json(['message' => 'Product rated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
