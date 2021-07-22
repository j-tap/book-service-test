<?php

namespace App\Services\BookReview;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
        $currentPage = $request->input('current_page') || 1;
        $bookId = $request->input('book_id') || null;

        $booksReview = BookReview::when($bookId, function (Builder $query) use($bookId)
        {
            // Search by name
            $query->where('book_id', '=', $bookId);
        })
        ->paginate(1, $currentPage);

        return new BookReviewCollection($booksReview);
    }
}
