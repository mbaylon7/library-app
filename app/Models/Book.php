<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Termwind\Components\Raw;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'isbn',
        'published_year',
        'publisher',
        'pages',
        'language',
        'description',
        'cover_image',
        'status'
    ];

    protected $requireFields = [
        'title',
        'author_id',
        'category_id',
        'isbn',
        'cover_image'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
