<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Author;

use App\Http\Resources\Author\AuthorResource;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;

use App\Services\Author\AuthorService;

class AuthorController extends Controller
{
    private $authorService;

    /**
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->authorService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = Author::create($request->validated());
        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->authorService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $author->update($request->validated());
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        // TODO: не совсем верный подход. проверкой удачности должна заниматься база данных
        // а если при деатаче прошла ошибка? т.е. с одной стороны удалил, а с другой стороны не полностью.
        // нужно просто конструкцию оборачивать в транзакцию от базы данных.
        // DB::beginTransaction; $book->authors()->detach(); $book->delete(); DB::commit;
        $success = $author->delete();
        if ($success) $success = $author->books()->detach();

        return [
            'data' => [
                'success' => $success,
            ]
        ];
    }
}
