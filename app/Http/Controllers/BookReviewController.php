<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ApiController as ApiController;
use App\Http\Requests\BookReview\BookReviewStoreRequest;
use App\Http\Requests\BookReview\BookReviewUpdateRequest;
use App\Services\BookReview\BookReviewService;

class BookReviewController extends ApiController
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
        $result = $this->bookReviewService->index($request);
        return $this->sendResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookReviewStoreRequest $request)
    {
        $result = $this->bookReviewService->store($request);
        return $this->sendResponse($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->bookReviewService->show($id);
        return $this->sendResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookReviewUpdateRequest $request, int $id)
    {
        $result = $this->bookReviewService->update($request, $id);
        return $this->sendResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return json
     */
    public function destroy(int $id)
    {
        $result = $this->bookReviewService->destroy($id);
        return $this->sendResponse($result);
    }
}
