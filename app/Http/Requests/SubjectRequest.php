<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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

    public function createRules() {
        return [
            'name' => 'required|unique:subjects,name|alpha'
        ];
    }

    public function updateRules() {
        return [
            'name' => 'required|alpha|unique:subjects'
        ];
    }

    public function rules()
    {
        if ($this->method() == 'POST') {
            return $this->createRules();
        } else if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return $this->updateRules();
        }
    }

    public function messages()
    {
        return [
            'name.regex' => 'The name must contain only letters.'
        ];
    }

    public function validated() {
        return $this->validate($this->rules());
    }
}
