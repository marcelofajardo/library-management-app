<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BookRequest extends FormRequest
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

    public function storeRules() {
        return [
            'title' => 'required|max:255',
            'isbn' => 'required|unique:books,isbn|digits_between:10,13',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'quantity' => 'required|integer'
        ];
    }

    public function updateRules() {
        return [
            'title' => 'required|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'quantity' => 'required|integer',
            'isbn' => [
                'required',
                'digits_between:10,13',
                Rule::unique('books')->ignore($this->book),
            ],
        ];
    }

    public function rules()
    {
        if ($this->method() == 'POST') {
           return $this->storeRules();
        } else if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return $this->updateRules($this->book);
        }
    }
}
