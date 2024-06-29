<?php

namespace App\Http\Requests;
use App\Traits\ApiResponsesTrait;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest  extends FormRequest
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
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => __('messages.phone_number_required'),
            'phone.numeric' => __('messages.phone_number_numeric'),
            'phone.min' => __('messages.phone_number_min'),
            'code.required' => __('messages.code_required'),

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
