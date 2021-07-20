<?php

namespace App\Services\Author;

use Illuminate\Http\Request;

use App\Models\Author;
use App\Http\Resources\Author\AuthorCollection;

class AuthorService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $authors = Author::all();

        $filterName = $request->input('name');

        // Search in title
        if ($filterName)
        {
            $authors = $authors->filter(function ($item) use ($filterName)
            {
                $authorName = "$item->first_name $item->last_name";
                return str_contains(mb_strtolower($authorName), mb_strtolower($filterName));
            });
        }

        return new AuthorCollection($authors);
    }
}
