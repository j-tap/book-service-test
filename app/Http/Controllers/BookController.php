<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;

use App\Http\Resources\Book\BookResource;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;

use App\Services\Book\BookService;

class BookController extends Controller
{
    private $bookService;

    /**
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Book
     */
    public function index(Request $request, $authorId = null)
    {
        return $this->bookService->index($request, $authorId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->validated());

        if ($request->has('authors'))
        {
            $authors = $request->input('authors');
            $book->authors()->attach($authors);
        }

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->bookService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $book->update($request->validated());

        $book->authors()->detach();

        if ($request->input('authors'))
        {
            $authors = $request->input('authors');
            $book->authors()->attach($authors);
        }

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $success = $book->delete();
        if ($success) $success = $book->authors()->detach();

        return [
            'data' => [
                'success' => $success,
            ]
        ];
    }

}
