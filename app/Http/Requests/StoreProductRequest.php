<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:products',
            'model' => 'nullable|string',
            'description' => 'nullable|string',
            'summary' => 'nullable|string',
            'price' => 'nullable|integer',
            'sale_price' => 'nullable|integer',
        ];
    }
}
