<?php

namespace App\Http\Requests\BookReview;

use Illuminate\Foundation\Http\FormRequest;

class BookReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'book_id' => 'required|integer|min:1',
            'text' => 'required',
            'rating' => 'integer|min:1|max:5',
        ];
    }
}
