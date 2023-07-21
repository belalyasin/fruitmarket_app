<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NutritionResources;
use App\Models\Nutrition;
use App\Models\Product;
use App\Models\Product_Nutrition;
use App\Models\Sub_Category;
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
        $products = Product::with(['category', 'product_nutrition'])->get();
        $data = $products->map(function ($product) {
            return [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "rate" => $product->rate,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $data = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "rate" => $product->rate,
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
