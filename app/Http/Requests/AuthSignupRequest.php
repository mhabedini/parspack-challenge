<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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

    protected function prepareForValidation()
    {
        $this->merge(['password' => Hash::make($this->input('password'))]);
    }
}
