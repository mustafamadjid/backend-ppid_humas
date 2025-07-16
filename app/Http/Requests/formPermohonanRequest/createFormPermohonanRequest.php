<?php

namespace App\Http\Requests\formPermohonanRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class createFormPermohonanRequest extends FormRequest
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
            'nama_pemohon' => [
                'required',
                'string',
                'max:300',
            ],
            'no_ktp_pemohon' => [
                'required',
                'string',
                'max:16',
            ],
            'alamat_pemohon' => [
                'required',
                'string',
                
            ],
            'no_telp_pemohon' => [
                'required',
                'string',
                'max:15',
            ],
            'email_pemohon' => [
                'required',
                'string',
                'email',
                
            ],
            'kebutuhan_informasi_pemohon' => [
                'required',
                'string',
                
            ],
            'alasan_permintaan' => [
                'required',
                'string',
                
            ],
            'nama_pengguna' => [
                'required',
                'string',
                'max:300',
            ],
            'no_ktp_pengguna' => [
                'required',
                'string',
                'max:16',
            ],
            'alamat_pengguna' => [
                'required',
                'string',
                
            ],
            'no_telp_pengguna' => [
                'required',
                'string',
                'max:15',
            ],
            'email_pengguna' => [
                'required',
                'string',
                'email',
                
            ],
            'kebutuhan_informasi_pengguna' => [
                'required',
                'string',
                
            ],
            'alasan_penggunaan' => [
                'required',
                'string',
            ],
            'cara_perolehan_informasi' => [
                'required',
                'string',
            ],
            'format_informasi' => [
                'required',
                'string',
            ],
            'cara_pengiriman_informasi' => [
                'required',
                'string',
            ],
        ];
    }

    public function failedValidation(Validator $validator){
        // Log semua input dan error validasinya
        Log::error('Validasi Form Permohonan Gagal', [
            
            'errors' => $validator->errors()->toArray(),
            'ip' => $this->ip(), // bisa juga user() jika pakai auth
        ]);

        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));

        
    }
}
