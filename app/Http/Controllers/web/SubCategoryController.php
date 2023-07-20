<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subCategories = Category::where('parent_id', '!=', NULL)->with('parentCategory')->get();
//        dd($subCategories);
        return response()->view('cms.subCategories.index', ['subCategories' => $subCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('parent_id', '=', NULL)->get();
        return response()->view('cms.subCategories.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'discount' => 'required|numeric',
            'description' => 'nullable|string|min:8',
            'parent_id' => 'required|numeric|exists:categories,id',
        ]);
        if (!$validator->fails()) {
            $category = new Category();
            $category->title = $request->input('title');
            $category->discount = $request->input('discount');
            $category->description = $request->input('description');
            $category->parent_id = $request->input('parent_id');
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
    public function edit(Category $subCategory)
    {
        //
        $categories = Category::where('parent_id', '=', NULL)->get();
        return response()->view('cms.subCategories.edit', ['categories' => $categories, 'subCategory' => $subCategory]);
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
    public function destroy(Category $subCategory)
    {
        //
//        dd($subCategory);
//        $subCategory = $subCategory->id;
        $subCategory->delete();
        return redirect()->back();
//        return redirect()->route('subCategories.index');
    }
}
