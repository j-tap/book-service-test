<?php

namespace App\Http\Resources\BookReview;

use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewResource extends JsonResource
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
            'book_id' => $this->book_id,
            'text' => $this->text,
            'rating' => $this->rating,
            // 'user_id' => $this->user_id,
        ];
    }
}
