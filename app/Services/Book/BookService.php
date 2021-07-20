<?php

namespace App\Services\Book;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Http\Resources\Book\BookCollection;

class BookService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $books = Book::all();

        $filterAuthors = $request->input('authors');
        $filterTitle = $request->input('title');

        // Filter by Authors
        if ($filterAuthors)
        {
            $authorsIds = explode(',', $filterAuthors);
            $books = $books->filter(function ($item) use ($authorsIds) {
                $is = false;
                foreach ($item->authors as $author)
                {
                    if (in_array($author->id, $authorsIds))
                    {
                        $is = true;
                        break;
                    }
                }
                return $is;
            });
        }
        // Search in title
        if ($filterTitle)
        {
            $books = $books->filter(function ($item) use ($filterTitle)
            {
                return str_contains(mb_strtolower($item->title), mb_strtolower($filterTitle));
            });
        }

        return new BookCollection($books);
    }
}
