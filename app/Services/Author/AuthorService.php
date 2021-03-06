<?php

namespace App\Services\Author;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Auth;
use App\Services\ControllerService as ControllerService;

use App\Models\Author;
use App\Http\Resources\Author\AuthorCollection;
use App\Http\Resources\Author\AuthorResource;

class AuthorService extends ControllerService
{
    /**
     * store
     *
     * @param  Array $request
     * @return AuthorResource
     */
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();
        if ($user)
        {
            $author = new Author();

            $author->first_name = $request->input('first_name');
            $author->last_name = $request->input('last_name');
            $author->birthday = $request->input('birthday');
            $author->description = $request->input('description');

            $author->save();

            return new AuthorResource($author);
        }
        else
        {
            return response('Unauthorized', 401);
        }
    }

    /**
     * update
     *
     * @param  Array $request
     * @param  int $id
     * @return AuthorResource
     */
    public function update(Request $request, int $id)
    {
        $user = auth('sanctum')->user();
        if ($user)
        {
            $author = Author::findOrFail($id);

            $author->first_name = $request->input('first_name');
            $author->last_name = $request->input('last_name');
            $author->birthday = $request->input('birthday');
            $author->description = $request->input('description');

            $author->save();

            return new AuthorResource($author);
        }
        else
        {
            return response('Unauthorized', 401);
        }
    }

    /**
     * Returns elements array.
     *
     * @return AuthorCollection
     */
    public function index(Request $request)
    {
        $name = Str::lower(trim($request->input('name')));
        $authors = Author::when($name, function (Builder $query) use($name)
        {
            // Search by name
            $query->where('first_name', 'ilike', "%$name%")
                ->orWhere('last_name', 'ilike', "%$name%");
        })
        ->get();

        return new AuthorCollection($authors);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return AuthorResource
     */
    public function show($id)
    {
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return json
     */
    public function destroy(int $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return response('OK');
    }
}
