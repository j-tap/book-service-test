<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ApiController as ApiController;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Services\Author\AuthorService;

class AuthorController extends ApiController
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
        $result = $this->authorService->index($request);
        return $this->sendResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $result = $this->authorService->store($request);
        return $this->sendResponse($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->authorService->show($id);
        return $this->sendResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, int $id)
    {
        $result = $this->authorService->update($request, $id);
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
        $result = $this->bookService->destroy($id);
        return $this->sendResponse($result);
    }
}
