<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'body' => ['required'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
