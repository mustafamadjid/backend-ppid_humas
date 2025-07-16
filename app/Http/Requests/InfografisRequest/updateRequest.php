<?php

namespace App\Http\Requests\InfografisRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

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
            'judul_infografis'=>[
                'sometimes',
                'string',
                'max:30'
            ],
            'file_gambar'=>[
                'sometimes',
                'mimes:jpeg,jpg,png',
                'max:5120'
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
