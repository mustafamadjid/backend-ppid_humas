<?php

namespace App\Http\Requests\ProfilPpidRequest;

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
            'deskripsi_profil' => [
                'sometimes', 
                'string',
            ],
            'visi_ppid' =>[
                'sometimes',
                'string',
                'max:255'
            ],
            'misi_ppid' =>[
                'sometimes',
                'string',
                'max:255'
            ],
            'tugas_ppid' =>[
                'sometimes',
                'string',
                'max:255'
            ],
            'fungsi_ppid' =>[
                'sometimes',
                'string',
                'max:255'
            ]
        ];
    }
}
