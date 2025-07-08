<?php

namespace App\Http\Requests\PegawaiRequest;

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
            "nama_pegawai" =>[
                "required",
                "string",
                "max:100"
            ],
            "email"=>[
                "required",
                "email",
                "max:100"
            ],
            "file_gambar"=>[
                "required",
                "file",
                "mimes:jpeg,jpg,png",
                "max:5120"
            ]
        ];
    }
}
