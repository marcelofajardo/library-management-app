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
        if ($this->method() == 'POST') {
            return $this->storeRules();
        } else if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return $this->updateRules();
        }

    }

    public function storeRules() {
        return [
            'user_id' => 'required|exists:users,id',
            'book_copy_id' => 'required|exists:book_copies,id'
        ];
    }

    public function updateRules() {
        return [
            'id' => 'required|exists:book_lendings,id',
            'damage_slt' => 'required|integer',
            'lateness_fine' => 'sometimes|filled|numeric|min:0',
            'damage_desc' => 'required_if:damage_slt,1|max:2000',
            'condition_id' => 'required_if:damage_slt,1|exists:book_conditions,id',
            'condition_fine' => 'nullable|required_if:damage_slt,1|numeric|min:1',
            'fine_checkbox' => 'required_with:condition_fine,lateness_fine'
        ];
    }
}
