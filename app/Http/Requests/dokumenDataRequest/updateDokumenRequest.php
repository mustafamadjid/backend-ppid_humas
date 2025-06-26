<?php

namespace App\Http\Requests\dokumenDataRequest;

use Illuminate\Foundation\Http\FormRequest;

class updateDokumenRequest extends FormRequest
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
            'nama_dokumen' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'kategori_dokumen' => [
                'sometimes',
                'string',
                'max:100'   
            ],
            'tahun_dokumen' => [
                'sometimes',
                'integer',
                "min:1900",
                "max:2100"
                
            ],
            'file_dokumen' => [
                'sometimes',
                'file',
                'mimes:jpeg,pdf',
                'max:20480'
            ]
        ];
    }
}
