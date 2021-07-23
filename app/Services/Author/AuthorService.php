<?php

namespace App\Services\Author;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Author;
use App\Http\Resources\Author\AuthorCollection;
use App\Http\Resources\Author\AuthorResource;

class AuthorService
{
    /**
     * Returns elements array.
     *
     * @return array
     */
    public function index(Request $request)
    {
        $name = mb_strtolower(trim($request->input('name')));
        $authors = Author::when($name, function (Builder $query) use($name)
        {
            // Search by name
            $query->where('first_name', 'ilike', "%$name%")
                ->orWhere('last_name', 'ilike', "%$name%");
        })
        ->get();

        return new AuthorCollection($authors);
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }
}
