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
    public function index(Request $request)
    {
        return $this->bookService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        // TODO: посмотреть пример реализации
        // почему весь этот функционал не в сервисе? зачем отправляешь на магию полученные значения из реквеста?
        // давай пример. у тебя есть какая-то модель в которой строку могут менять и админы и пользователи.
        // но так как ты всё отдаешь на откуп ларавель, пользователь зная какое поле передать в реквесте,
        // то, сможет изменить это значения. например при редактировании себя и установив галочку is_admin.
        // проще конкретно прописать $book->name = $request->get('name'); и т.д.
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
        // TODO: не совсем верный подход. проверкой удачности должна заниматься база данных
        // а если при деатаче прошла ошибка? т.е. с одной стороны удалил, а с другой стороны не полностью.
        // нужно просто конструкцию оборачивать в транзакцию от базы данных.
        // DB::beginTransaction; $book->authors()->detach(); $book->delete(); DB::commit;
        $success = $book->delete();
        if ($success) $success = $book->authors()->detach();

        return [
            'data' => [
                'success' => $success,
            ]
        ];
    }

}
