<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthSignupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // TODO prevent profanity in username if it's necessary
        return [
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
        ];
    }

    // TODO hash the password
    /*protected function prepareForValidation()
    {
        $this->request->replace([
            'password' => Hash::make($this['password']),
        ]);
    }*/
}
