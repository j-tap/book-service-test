<?php

namespace App\Http\Resources\BookReview;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return BookReviewResource::collection($this->collection);
    }
}
