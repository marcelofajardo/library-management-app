<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
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
            'name' => 'required|unique:publishers,name'
        ];
    }

    public function updateRules() {
        return [
            'name' => 'required|unique:publishers,name'
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
}
