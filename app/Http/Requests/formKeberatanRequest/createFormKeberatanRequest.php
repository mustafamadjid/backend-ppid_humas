<?php

namespace App\Http\Requests\formKeberatanRequest;

use Illuminate\Foundation\Http\FormRequest;

class createFormKeberatanRequest extends FormRequest
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
            'nama_pemohon'=>[
                    'required',
                    'string',
                    'max:120',
                ],
                'no_ktp_pemohon'=>[
                    'required',
                    'string',
                    'max:16',
                ],
                'email_pemohon'=>[
                    'required',
                    'string',
                    'email',
                    'max:150',
                ],
                'alamat_pemohon' =>[
                    'required',
                    'string',
                ],
                'no_telp_pemohon'=>[
                    'required',
                    'string',
                    'max:13',
                ],
                'pekerjaan_pemohon' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'tujuan_pengajuan' => [
                    'required',
                    'string',
                ],
                'alasan_pengajuan' => [
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
}
