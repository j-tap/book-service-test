<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuthorResource::collection(Author::all());
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
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'birthday' => 'date',
        ]);

        $author = Author::create($request->all());

        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return new AuthorResource(Author::findOrFail($author['id']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        request()->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'birthday' => 'date',
        ]);

        $author->update($request->only([
            'first_name',
            'last_name',
            'birthday',
            'description',
        ]));

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
        $success = $author->delete();
        if ($success)
        {
            $success = $author->books()->detach();
        }

        return [
            'data' => [
                'success' => $success,
            ]
        ];
    }
}
