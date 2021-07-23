<?php

namespace App\Services\BookReview;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BookReview;
use App\Http\Resources\BookReview\BookReviewCollection;

use App\Http\Resources\BookReview\BookReviewResource;

class BookReviewService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $counItems = 5;
        $bookId = null;
        if ($request->has('book_id')) $bookId = $request->input('book_id');

        $booksReview = BookReview::when($bookId, function (Builder $query) use($bookId)
        {
            // Search by name
            $query->where('book_id', '=', $bookId);
        })
        ->simplePaginate($counItems);

        return new BookReviewCollection($booksReview);
    }

    public function show($id)
    {
        $bookReview = BookReview::findOrFail($id);
        return new BookReviewResource($bookReview);
    }
}
