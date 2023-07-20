<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::where('parent_id', '=', null)->get();
        return response()->view('cms.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return response()->view('cms.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|min:10'
        ]);
        if (!$validator->fails()) {
            $category = new Category();
            $category->title = $request->input('title');
            $category->description = $request->input('description');
            $category->parent_id = null;
            $isSaved = $category->save();
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
    public function edit(Category $category)
    {
        //
        return response()->view('cms.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|min:10'
        ]);
        if (!$validator->fails()) {
            $category->title = $request->input('title');
            $category->description = $request->input('description');
            $category->parent_id = null;
            $isSaved = $category->save();
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
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return redirect()->back();
    }
}
