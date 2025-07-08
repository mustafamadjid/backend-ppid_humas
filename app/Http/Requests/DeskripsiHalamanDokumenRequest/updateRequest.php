<?php

namespace App\Http\Requests\DeskripsiHalamanDokumenRequest;

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
            'deskripsi' => [
                'sometimes', 
                'string',
            ],
            'kategori_dokumen' => [
                'sometimes',
                'string',
                'max:100'   
            ]
        ];
    }
}
