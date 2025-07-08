<?php

namespace App\Http\Requests\BannerBerandaRequest;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
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
            'file_gambar' => [
                'sometimes',
                'file',
                'mimes:jpeg,jpg,png',
                'max:20480'
            ],
            'order' => [
                'sometimes',
                'integer',
                'min:1',
                'max:5'
            ],
            'is_active' => [
                'sometimes',
                'integer',
                'min:0',
                'max:1'
            ]
        ];
    }
}
