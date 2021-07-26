<?php

namespace App\Services\Book;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use App\Models\Book;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Book\BookWithAuthorsResource;

class BookService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $title = Str::lower($request->input('title'));
        $authorsIds = null;
        if ($request->filled('authors')) $authorsIds = explode(',', $request->input('authors'));

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

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return new BookWithAuthorsResource($book);
    }
}
