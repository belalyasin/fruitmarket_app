<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Nutrition;
use App\Models\Product;
use App\Models\Product_Nutrition;
use App\Models\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('category')->get();
        return response()->view('cms.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $subCategories = Category::where('parent_id', '!=', NULL)->get();
        $nutrients = Nutrition::all();
        // dd($subCategories);
        // dd($nutrients);
        return response()->view('cms.products.create', ['subCategories' => $subCategories, 'nutrients' => $nutrients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            "price" => 'required|numeric',
            // "range_5" => 'required|integer',
            "rate" => 'required|numeric',
            "description" => 'required|string',
            "image" => 'required|file|mimes:jpeg,png,jpg',
            "category_id" => 'required|numeric|exists:App\Models\Category,id',
            "nutrients" => 'required|array',
            "nutrients.*" => 'exists:App\Models\Nutrition,id',
        ]);
        // dd($request);
        if (!$validator->fails()) {
            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->rate = $request->input('rate');
            $product->description = $request->input('description');
            $product->category_id = $request->input("category_id");
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // Save the image path to the product
                $path = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('images'), $path);
                $product->image = $path;
            }
            $isSaved = $product->save();
            if ($request->hasAny('nutrients')) {
                $nutrients = $request->input('nutrients');
                foreach ($nutrients as $nutrient) {
                    $product_nutrition = new Product_Nutrition();
                    $product_nutrition->product_id = $product->id;
                    $product_nutrition->nutrition_id = $nutrient;
                    $product_nutrition->save();
                }
            }
            return response()->json(
                [
                    'message' => $isSaved ? 'Created Successfuly' :
                        'Created Failed!',
                ],
                $isSaved ? Response::HTTP_CREATED :
                    Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
//        dd($product);
        $subCategories = Category::where('parent_id', '!=', NULL)->get();
        $nutrients = Nutrition::all();
        $selected_nutrient = Nutrition::whereIn('id', $product->product_nutrition->pluck('nutrition_id'))->get();
//        dd($nutrients);
        return response()->view('cms.products.edite', ['subCategories' => $subCategories, 'selected_nutrient' => $selected_nutrient, 'nutrients' => $nutrients, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            "price" => 'required|numeric',
            // "range_5" => 'required|integer',
            "rate" => 'required|numeric',
            "description" => 'required|string',
            "image" => 'required|file|mimes:jpeg,png,jpg',
            "category_id" => 'required|numeric|exists:App\Models\Category,id',
            "nutrients" => 'required|array',
            "nutrients.*" => 'exists:App\Models\Nutrition,id',
        ]);
//         dd($request);
        if (!$validator->fails()) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->rate = $request->rate;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('images'), $path);
                // Save the image path to the product
                $product->image = $path;
            }
            $isSaved = $product->save();
            if ($request->hasAny('nutrients')) {
                $nutrients = $request->input('nutrients');
                // Delete existing product_nutrition that are not in the updated nutrients array
                $existingNutrients = $product->product_nutrition->pluck('nutrition_id')->toArray();
                $deletedNutrients = array_diff($existingNutrients, $nutrients);
                Product_Nutrition::where('product_id', $product->id)->whereIn('nutrition_id', $deletedNutrients)->delete();
                foreach ($nutrients as $nutrient) {
                    $product_nutrition = Product_Nutrition::where('product_id', $product->id)->where('nutrition_id', $nutrient)->first();
//                    $product_nutrition = Product_Nutrition::updateOrCreate();
                    if (!$product_nutrition) {
                        $product_nutrition = new Product_Nutrition();
                        $product_nutrition->product_id = $product->id;
                        $product_nutrition->nutrition_id = $nutrient;
                    }
                    $product_nutrition->save();
                }
            }
            return response()->redirectToRoute('products.index');
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
//        dd('delete');
        $product->delete();
//        return redirect()->viewPath('cms.products.index');
        return redirect()->back();
    }
}
