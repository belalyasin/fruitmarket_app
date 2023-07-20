<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Nutrition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class NutritionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nutritions = Nutrition::all();
        return response()->view('cms.nutrition.index', ['nutritions' => $nutritions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.nutrition.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'description' => 'nullable|string|min:10'
        ]);
        if (!$validator->fails()) {
            $nutritions = new Nutrition();
            $nutritions->name = $request->input('name');
            $nutritions->description = $request->input('description');
            $isSaved = $nutritions->save();
            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
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
    public function edit(Nutrition $nutrition)
    {
        //
        return response()->view('cms.nutrition.edit', ['nutrition' => $nutrition]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nutrition $nutrition)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'description' => 'nullable|string|min:10'
        ]);
        if (!$validator->fails()) {
//            $nutritions = new Nutrition();
            $nutrition->name = $request->input('name');
            $nutrition->description = $request->input('description');
            $isSaved = $nutrition->save();
            return response()->json(
                ['message' => $isSaved ? 'Updated successfully' : 'Update failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nutrition $nutrition)
    {
        //
        $nutrition->delete();
        return redirect()->back();
    }
}
