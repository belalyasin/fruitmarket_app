<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubCategoryResources;
use App\Models\Category;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subCategories = Category::where('parent_id','!=',null)->with('products')->get();
        $data = $subCategories->map(function ($subCategory) {
            return [
                'id' => $subCategory->id,
                'title' => $subCategory->title,
                'discount' => $subCategory->discount,
                'description' => $subCategory->description,
                'products' => $subCategory->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'rate' => $product->rate,
                        'description' => $product->description,
                        'image' => $product->image,
                        'isFavorite' => $product->isFavorite ? true : false,
                    ];
                }),
            ];
        });

        return response()->json(['data' => $data], 200);
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
