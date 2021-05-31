<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|max:100',
            'pages_count' => 'required',
            'year' => 'required',
        ]);

        $book = Book::create($request->all());

        if ($request->input('authors'))
        {
            $authors = $request->input('authors');
            Book::authors()->attach($authors);
        }

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource(Book::findOrFail($book['id']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        request()->validate([
            'title' => 'required|max:100',
            'pages_count' => 'required',
            'year' => 'required',
        ]);

        $book->update($request->only([
            'title',
            'description',
            'pages_count',
            'year',
        ]));

        $book->authors()->detach();

        if ($request->input('authors'))
        {
            $authors = $request->input('authors');
            $book = $book->authors()->attach($authors);
        }

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $success = $book->delete();
        if ($success)
        {
            $success = $book->authors()->detach();
        }

        return [
            'success' => $success
        ];
    }
}
