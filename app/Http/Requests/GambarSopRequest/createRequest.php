<?php

namespace App\Http\Requests\GambarSopRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

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
            'file_gambar' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png',
                'max:20480'
            ],
            'judul_sop' => [
                'required',
                'string',
                'max:50'
            ]
        ];
    }
    public function failedValidation(Validator $validator){
        Log::error('Validasi Gagal', [
           
            'errors' => $validator->errors()->toArray(),
            'ip' => $this->ip(),
        ]);

        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
