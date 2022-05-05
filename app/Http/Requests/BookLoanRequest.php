<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookLoanRequest extends FormRequest
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
            'damage_slt' => 'required|integer',
            'lateness_fine' => 'nullable|numeric|min:0',
            'damage_desc' => 'required_if:damage_slt,1|max:2000',
            'condition_id' => 'required_if:damage_slt,1|exists:book_conditions,id',
            'condition_fine' => 'nullable|required_if:damage_slt,1|numeric|min:1',
            'fine_checkbox' => 'required_if:damage_slt,1|required_with:lateness_fine'
        ];
    }

    public function messages() {
        return [
            'damage_slt.required' => 'Please select one of the options.',
            'damage_desc.required_if' => 'Enter the description.',
            'damage_desc.max' => 'The description can contain a maximum of 2000 characters.',
            'condition_fine.required_if' => 'Enter the fine.',
            'condition_fine.numeric' => 'Please use only numbers',
            'condition_fine.min' => 'A minimum fine is 1€',
            'fine_checkbox.required_if' => 'The checkbox must be checked.',
            'fine_checkbox.required_with' => 'The checkbox must be checked.',
        ];
    }
}
