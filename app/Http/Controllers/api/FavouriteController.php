<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        // dd($user);
        $favorites = Favourite::where('user_id', '=', $user->id)->with('product')->get();
        // dd($favorites);
        $data = $favorites->map(function ($favorite) {
            return [
                "id" => $favorite->id,
                "name" => $favorite->product->name,
                "price" => $favorite->product->price,
                "rate" => $favorite->product->rate,
                // "description" => $favorite->description,
                "image" => $favorite->product->image,
                "count" => $favorite->count,
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
