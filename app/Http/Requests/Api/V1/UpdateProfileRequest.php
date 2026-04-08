<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'height' => ['sometimes', 'numeric', 'min:50', 'max:300'],
            'weight' => ['sometimes', 'numeric', 'min:20', 'max:300'],
            'age' => ['sometimes', 'integer', 'min:1', 'max:150'],
        ];
    }
}
