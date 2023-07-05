<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NutritionResources;
use App\Models\Nutrition;
use App\Models\Product;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with(['sub__category', 'product_nutrition'])->get();
        $data = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "rate" => $product->rate,
                "description" => $product->description,
                "image" => $product->image,
                "isFavorite" => $product->isFavorite ? true : false,
                "sub_categories" => $product->sub__category ? $product->sub__category->title : null,
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
