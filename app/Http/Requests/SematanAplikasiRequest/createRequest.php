<?php

namespace App\Http\Requests\SematanAplikasiRequest;

use Illuminate\Foundation\Http\FormRequest;

class createRequest extends FormRequest
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
            'judul_sematan' =>[
                'required',
                'string',
                'max:50'
            ],
            'url_sematan'=>[
                'required',
                'url',
                'max:255'
            ],
            'icon'=>[
                'sometimes',
                'string',
                'max:100'
            ]
        ];
    }
}
