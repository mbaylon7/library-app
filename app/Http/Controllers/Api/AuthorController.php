<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::get();

        return response()->json($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:authors,name',
            'description' => 'nullable|string',
            'status' => 'in:archived,active'
        ]);

        $author = Author::create($validated);

        return response()->json(['message' => 'Author added successfully', 'data' => $author]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $author->get();

        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|unique:authors,name,' . $author->id,
            'description' => 'nullable|string',
            'status' => 'in:archived,active'
        ]);

        $author->update($validated);

        return response()->json(['message' => 'Author details updated successfully.', 'data' => $author]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $author->delete();

        return response()->json(['message' => 'Author deleted successfully.']);
    }
}
