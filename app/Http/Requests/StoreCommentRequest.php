<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // any authenticated user can comment — enforced by route middleware
    }

    public function rules(): array
    {
        return [
            'comment' =>['required', 'string', 'max:1000'],
        ];
    }
}