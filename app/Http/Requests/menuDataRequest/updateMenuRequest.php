<?php

namespace App\Http\Requests\menuDataRequest;

use Illuminate\Foundation\Http\FormRequest;

class updateMenuRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul_menu' => [
                    'sometimes',
                    'string',
                    'max:150',
                ],
                'url' => [
                    'sometimes',
                    'string',
                    'url'
                ]
        ];
    }
}
