<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            "user_id" => ['required', 'string', 'exists:users,id', 'uuid', 'size:36', 'alpha_dash'],
            "total" => ['required', 'integer', 'min:1', 'gt:0'],
            "products" => ['required', 'array', 'min:1', 'distinct']
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
