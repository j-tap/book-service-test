<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BookReview;

use App\Http\Requests\BookReview\BookReviewStoreRequest;
use App\Http\Requests\BookReview\BookReviewUpdateRequest;

use App\Http\Resources\BookReview\BookReviewResource;

use App\Services\BookReview\BookReviewService;

class BookReviewController extends Controller
{
    private $bookReviewService;

    /**
     * @param BookReviewService $bookReviewService
     */
    public function __construct(BookReviewService $bookReviewService)
    {
        $this->bookReviewService = $bookReviewService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->bookReviewService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookReviewStoreRequest $request)
    {
        $bookReview = BookReview::create($request->validated());
        return new BookReviewResource($bookReview);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->bookReviewService->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookReviewUpdateRequest $request, BookReview $bookReview)
    {
        $bookReview->update($request->validated());
        return new BookReviewResource($bookReview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookReview $bookReview)
    {
        // TODO: не совсем верный подход. проверкой удачности должна заниматься база данных
        // а если при деатаче прошла ошибка? т.е. с одной стороны удалил, а с другой стороны не полностью.
        // нужно просто конструкцию оборачивать в транзакцию от базы данных.
        // DB::beginTransaction; $book->authors()->detach(); $book->delete(); DB::commit;
        $success = $bookReview->delete();
        return [
            'data' => [
                'success' => $success,
            ]
        ];
    }
}
