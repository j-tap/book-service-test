<?php

namespace App\Services\BookReview;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Services\ControllerService as ControllerService;

use App\Models\BookReview;
use App\Http\Resources\BookReview\BookReviewCollection;
use App\Http\Resources\BookReview\BookReviewResource;

class BookReviewService extends ControllerService
{
    /**
     * store
     *
     * @param  Array $request
     * @return BookReviewResource
     */
    public function store(Request $request)
    {
        $bookReview = new BookReview();

        $bookReview->book_id = $request->input('book_id');
        $bookReview->text = $request->input('text');
        $bookReview->rating = $request->input('rating');

        $bookReview->save();

        return new BookReviewResource($bookReview);
    }

    /**
     * update
     *
     * @param  Array $request
     * @param  int $id
     * @return BookReviewResource
     */
    public function update(Request $request, int $id)
    {
        $user = auth('sanctum')->user();
        if ($user)
        {
            $bookReview = BookReview::findOrFail($id);

            $bookReview->text = $request->input('text');
            $bookReview->rating = $request->input('rating');

            $bookReview->save();

            return new BookReviewResource($bookReview);
        }
        else
        {
            return response('Unauthorized', 401);
        }
    }

    /**
     * index
     *
     * @param  Request $request
     * @return BookReviewCollection
     */
    public function index(Request $request)
    {
        $counItems = 5;
        $bookId = null;
        if ($request->filled('book_id')) $bookId = $request->input('book_id');

        $booksReview = BookReview::when($bookId, function (Builder $query) use($bookId)
        {
            // Search by name
            $query->where('book_id', '=', $bookId);
        })
        ->simplePaginate($counItems);

        return new BookReviewCollection($booksReview);
    }

    /**
     * show
     *
     * @param  int $id
     * @return BookReviewResource
     */
    public function show(int $id)
    {
        $bookReview = BookReview::findOrFail($id);
        return new BookReviewResource($bookReview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return json
     */
    public function destroy(int $id)
    {
        $bookReview = BookReview::findOrFail($id);
        $bookReview->delete();

        return response('OK');
    }
}
