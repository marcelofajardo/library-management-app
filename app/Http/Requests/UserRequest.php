<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
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
            'first_name' => 'required|max:125',
            'last_name' => 'required|max:125',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|max:255'
        ];
    }

    public function updateRules() {
        return [
            'name' => 'required|max:255',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email|max:255'
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
            'role_id.required' => 'You must choose a role.'
        ];
    }

    public function validated() {
        $validated = $this->validate($this->rules());

        if ($this->method() == 'POST') {
            $name = join(" ", [$validated['first_name'], $validated['last_name']]);
            $validated['name'] = $name;

            unset($validated['first_name']);
            unset($validated['last_name']);

            $validated['password'] = Hash::make($validated['password']);
        }

        return $validated;
    }
}
