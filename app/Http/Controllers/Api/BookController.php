<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with([
            'author', 'category', 'tags', 'ratings'
        ])->get();

        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:books,title',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|unique:books,isbn',
            'published_year' => 'nullable|digits:4|integer',
            'publisher' => 'nullable|string',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'status' => 'in:borrowed,available,unavailable,reserved,soon_to_be_available,archived',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $book = Book::create($validated);

        if (isset($validated['tags'])) {
            $book->tags()->sync($validated['tags']);
        }

        return response()->json(['message' => 'Book added successfully', 'data' => $book], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $book->load([
            'author',
            'category',
            'tags',
            'ratings'
        ]);

        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|unique:books,title,' . $book->id,
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'isbn' => 'sometimes|required|unique:books,isbn,' . $book->id,
            'published_year' => 'nullable|digits:4|integer',
            'publisher' => 'nullable|string',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'status' => 'in:borrowed,available,unavailable,reserved,soon_to_be_available,archived',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $book->update($validated);

        if (isset($validated['tags'])) {
            $book->tags()->sync($validated['tags']);

            return response()->json(['message' => 'Book details updated successfully', 'data' => $book]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.']);
    }

}
