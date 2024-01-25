<?php

namespace App\Http\Requests\Product;

use App\Rules\Double;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:30', 'not_in:Admin,Manager'],
            'description' => ['required', 'string', 'max:255', 'bail'],
            'price' => ['required', new Double()],
            'image_url' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id', 'uuid'],
            'is_available' => ['boolean', 'nullable', 'in:true,false,1,0']
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
