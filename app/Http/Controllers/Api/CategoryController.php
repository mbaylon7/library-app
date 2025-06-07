<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
            'status'    => 'in:inactive,active'
        ]);

        $category = Category::create($validated);

        return response()->json(['message' => 'Categories added successfully.', 'data' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $category->get();

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'status'    => 'in:inactive,active'
        ]);

        $category->update($validated);

        return response()->json(['message' => 'Category details updated successfully.', 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category delete successfully.']);
    }
}
