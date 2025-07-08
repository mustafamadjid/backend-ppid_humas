<?php

namespace App\Http\Requests\PegawaiRequest;

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
            "nama_pegawai" =>[
                "sometimes",
                "string",
                "max:100"
            ],
            "email"=>[
                "sometimes",
                "email",
                "max:100"
            ],
            "file_gambar"=>[
                "sometimes",
                "file",
                "mimes:jpeg,jpg,png",
                "max:5120"
            ]
        ];
    }
}
