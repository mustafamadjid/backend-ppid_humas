<?php

namespace App\Http\Requests\ProfilPpidRequest;

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
            'deskripsi_profil' => [
                'required', 
                'string',
            ],
            'visi_ppid' =>[
                'required',
                'string',
                'max:255'
            ],
            'misi_ppid' =>[
                'required',
                'string',
                'max:255'
            ],
            'tugas_ppid' =>[
                'required',
                'string',
                'max:255'
            ],
            'fungsi_ppid' =>[
                'required',
                'string',
                'max:255'
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
