<?php

namespace App\Services\BookReview;

use Illuminate\Http\Request;

use App\Models\BookReview;
use App\Http\Resources\BookReview\BookReviewCollection;

class BookReviewService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $booksReview = BookReview::all();
        return new BookReviewCollection($booksReview);
    }
}
