<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AuthLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required_without:username|email',
            'username' => 'required_without:email|string',
            'password' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->password = Hash::make($this->input('password'));
    }
}
