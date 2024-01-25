<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthSignInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:50', 'not_in:admin@gmail.pt', 'different:name', 'filled'],
            'password' => ['required', 'string', 'min:6', 'max:255', 'filled'],
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
