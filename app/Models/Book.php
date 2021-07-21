<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'pages_count',
        'year',
    ];

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_to_book', 'book_id', 'author_id');
    }
}
