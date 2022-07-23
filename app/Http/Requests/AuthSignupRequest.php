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
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ];
    }

    /*protected function prepareForValidation()
    {
        $this->request->replace([
            'password' => Hash::make($this['password']),
        ]);
    }*/
}
