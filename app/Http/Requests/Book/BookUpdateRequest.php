<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            // TODO: проверять authors
            // а если передали не айди, а текст/массив/etc? а если передали уже удаленного автора?
            'title' => ['required', 'max:100'],
            'pages_count' => ['required', 'integer', 'min:1'],
        ];
    }
}
