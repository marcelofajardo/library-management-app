<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
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

    public function createRules() {
        return [
            'name' => 'required|unique:genres,name|alpha'
        ];
    }

    public function updateRules() {
        return [
            'name' => 'required|alpha|unique:genres'
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

    public function validated() {
        return $this->validate($this->rules());
    }

    public function messages()
    {
        return [
            'name.alpha' => 'The name must contain only letters and/or a dash.'
        ];
    }
}
