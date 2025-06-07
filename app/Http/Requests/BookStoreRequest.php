<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
