<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthSignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z\s]+$/', 'filled'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email', 'not_in:admin@gmail.pt', 'different:name', 'filled'],
            'password' => ['required', 'string', 'min:6', 'max:255', 'not_in:password,123456,admin', 'not_regex:/^[a-zA-Z\s]+$/', 'filled'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'   => false,
                'message'   => 'Validation errors',
                'data'      => $validator->errors()
            ], 400));
    }
}
