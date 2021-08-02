<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookLendingRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'book_copy_id' => 'required|exists:book_copies,id'
        ];
    }
}
