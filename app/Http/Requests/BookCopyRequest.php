<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCopyRequest extends FormRequest
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
            'price' => 'required|array|min:1',
            'price.*' => 'required|numeric|min:0',
            'date_of_purchase' => 'required|array|min:1',
            'date_of_purchase.*' => 'required|date|before_or_equal:today',
            'publication_date' => 'required|array|min:1',
            'publication_date.*' => 'required|date|before:date_of_purchase.*',
            'edition' => 'required|array|min:1',
            'edition.*' => 'required|numeric|min:1',
            'condition_id' => 'required|array|min:1',
            'condition_id.*' => 'required|exists:book_conditions,id',
            'book_id' => 'required|exists:books,id',
            'book_status_id' => 'required|array|min:1',
            'book_status_id.*' => 'required|exists:book_statuses,id'
        ];
    }

    public function updateRules() {
        return [
            'price' => 'required|numeric|min:0',
            'date_of_purchase' => 'required|date|before_or_equal:today',
            'publication_date' => 'required|date|before:today',
            'edition' => 'required|numeric',
            'condition_id' => 'required|exists:book_conditions,id',
            'id' => 'required|exists:book_copies,id',
            'book_status_id' => 'required|exists:book_statuses,id'
        ];
    } 


    public function rules()
    {
        if ($this->method() == 'POST') {
            return $this->storeRules();
        } else if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return $this->updateRules();
        }
    }

}
