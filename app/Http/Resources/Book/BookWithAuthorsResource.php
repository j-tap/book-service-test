<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Author\AuthorResource;

class BookWithAuthorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'pages_count' => $this->pages_count,
            'year' => $this->year,
            'authors' => AuthorResource::collection($this->authors),
        ];
    }
}
