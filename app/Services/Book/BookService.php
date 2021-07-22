<?php

namespace App\Services\Book;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Book;
use App\Models\Author;
use App\Http\Resources\Book\BookCollection;

class BookService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request, $authorId)
    {
        $title = mb_strtolower(trim($request->input('title')));
        $authorsIds = null;
        if (isset($authorId)) $authorsIds = [ $authorId ];
        elseif ($request->has('authors')) $authorsIds = explode(',', $request->input('authors'));

        $books = Book::when($title, function (Builder $query) use($title)
        {
            // Search in title
            $query->where('title', 'ilike', "%$title%");
        })
        ->when($authorsIds, function (Builder $query) use($authorsIds)
        {
            $query->whereHas('authors', function (Builder $q) use($authorsIds)
            {
                // Get by authors
                $q->whereIn('id', $authorsIds);
            });
        })
        ->get();

        return new BookCollection($books);
    }
}
