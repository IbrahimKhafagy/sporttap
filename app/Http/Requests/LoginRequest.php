<?php

namespace App\Http\Requests;
use App\Traits\ApiResponsesTrait;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use ApiResponsesTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|numeric|min:8',
            // Add any additional validation rules here
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => __('messages.phone_number_required'),
            'phone.numeric' => __('messages.phone_number_numeric'),
            'phone.min' => __('messages.phone_number_min'),
            // Add custom messages for other rules as needed
        ];
    }

    // Override the response method to return only the first error message
    protected function failedValidation($validator)
    {
        $firstError = $validator->errors()->first();

        $response = $this->errorResponse($firstError, 401);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
