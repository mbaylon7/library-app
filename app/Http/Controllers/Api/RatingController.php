<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::get();

        $user = auth()->user()->id;

        return response()->json([
            'message' => 'User details',
            'data' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'score' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->user->id();

        $rating = Rating::create($validated);

        return response()->json(['message' => 'Rating added successfully', 'data' => $rating], 201);
    }
}
