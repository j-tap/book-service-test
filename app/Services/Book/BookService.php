<?php

namespace App\Services\Book;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Book;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Book\BookWithAuthorsResource;

class BookService
{
    /**
     * store
     *
     * @param  Array $request
     * @return BookResource
     */
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->pages_count = $request->input('pages_count');
        $book->year = $request->input('year');

        DB::beginTransaction();
        $book->save();
        if ($request->has('authors'))
        {
            $authors = $request->input('authors');
            $book->authors()->attach($authors);
        }
        DB::commit();

        return new BookResource($book);
    }

    /**
     * update
     *
     * @param  Array $request
     * @param  int $id
     * @return BookResource
     */
    public function update(Request $request, int $id)
    {
        $book = Book::findOrFail($id);

        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->pages_count = $request->input('pages_count');
        $book->year = $request->input('year');

        DB::beginTransaction();
        $book->update($request);
        $book->authors()->detach();
        if ($request->input('authors'))
        {
            $authors = $request->input('authors');
            $book->authors()->attach($authors);
        }
        DB::commit();

        return new BookResource($book);
    }

    /**
     * index
     *
     * @param  Request $request
     * @return BookCollection
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

    /**
     * show
     *
     * @param  int $id
     * @return BookWithAuthorsResource
     */
    public function show(int $id)
    {
        $book = Book::findOrFail($id);
        return new BookWithAuthorsResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return json
     */
    public function destroy(int $id)
    {
        $book = Book::findOrFail($id);

        DB::beginTransaction();
        $book->authors()->detach();
        $book->delete();
        DB::commit();

        return response()->json();
    }
}
