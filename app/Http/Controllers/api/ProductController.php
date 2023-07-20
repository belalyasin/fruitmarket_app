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
        $validation = Validator($request->all(), [
            "name" => 'required|string|min:3',
            "price" => 'required|double',
            "rate" => 'required|integer',
            "description" => 'required|string',
            "image" => 'required|file|mimes:jpeg,png,jpg',
            "subcategoryId" => 'required|numeric|exists:App\Models\Sub_Category,id',
            "nutrients" => 'required|array',
            "nutrients.*" => 'exists:App\Models\Nutrition,id',
        ]);
        if (!$validation->fails()) {
            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->rate = $request->input('rate');
            $product->description = $request->input('description');
            $product->category_id = $request->input("subcategoryId");
            try{
                if ($request->has('nutrients')) {
                    $nutrients = $request->input('nutrients');
                    foreach ($nutrients as $key => $value){
                        Product_Nutrition::create([
                            "product_id"=>$product->id,
                            "nutrient_id"=>$value["nutrient"],
                            "amountIn100g"=>(int)$value["amount"]*10
                            ]);
                    }
                }
                $path=$this->uploadImage($request);
                $product->imageUrl="http://localhost/api/$path";
                $product->saveOrFail();
            }
            catch(\Exception $e){
                dd($e);
                throw  new \Exception;
            }
        } else {
            return response()->json(
                [
                    "message" => $validation->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
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
