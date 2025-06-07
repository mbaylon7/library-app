<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::with('books')->get();

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tags,name',
            'status' => 'in:archived,active'
        ]);

        $tag = Tag::create($validated);

        return response()->json(['message' => 'Tag added successfully.', 'data' => $tag]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|unique:tags,name,' . $tag->id,
            'status' => 'in:archived,active'
        ]);

        $tag->update($validated);

         return response()->json(['message' => 'Record details updated successfully.', 'data' => $tag]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag delete successfully.']);
    }
}
