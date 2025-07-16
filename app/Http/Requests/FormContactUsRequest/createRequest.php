<?php

namespace App\Http\Requests\FormContactUsRequest;

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
            'nama_lengkap' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:100',
            ],
            'no_telp' => [
                'required',
                'string',
                'max:15',
            ],
            'subjek' => [
                'required',
                'string',
                'max:100',
            ],
            'pesan' => [
                'required',
                'string',
            ],
        ];
    }
    public function failedValidation(Validator $validator){
        // Log semua input dan error validasinya
        Log::error('Validasi Form Gagal', [
            
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
