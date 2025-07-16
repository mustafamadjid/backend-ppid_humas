<?php

namespace App\Http\Requests\userDataRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->id, 'id_user'),
            ],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->id, 'id_user'),
            ],
            'password' => [
                'sometimes',
                'string',
                'min:6',
            ],
            'role' => [
                'sometimes',
                'string',
                'max:255',
            ],
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
