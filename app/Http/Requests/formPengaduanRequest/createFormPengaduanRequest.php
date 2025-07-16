<?php

namespace App\Http\Requests\formPengaduanRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class createFormPengaduanRequest extends FormRequest
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
            'nama_pelapor'=>[
                'required',
                'string',
                'max:120',
            ],
            'no_ktp_pelapor'=>[
                'required',
                'string',
                'max:16',
            ],
            'email_pelapor'=>[
                'required',
                'string',
                'email',
                'max:150',
            ],
            'no_telp_pelapor'=>[
                'required',
                'string',
                'max:13',
            ],
            'nama_terlapor' => [
                'required',
                'string',
                'max:120',
            ],
            'jabatan_terlapor' => [
                'required',
                'string',
                'max:50',
            ],
            'deskripsi_penyalahgunaan' => [
                'required',
                'string',
            ],
            'file_bukti' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480'
            ]
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
