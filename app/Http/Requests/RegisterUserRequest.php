<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:providers',
            'phone' => 'required|string|max:255|unique:providers',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required'),
            'email.required' => __('validation.required'),
            'email.email' => __('validation.email'),
            'email.unique' => __('validation.unique'),
            'phone.required' => __('validation.required'),
            'phone.unique' => __('validation.unique'),
            'password.required' => __('validation.required'),
            'password.min' => __('validation.min.string', ['min' => 8]),
            'password.confirmed' => __('validation.confirmed'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $firstError = [];

        foreach ($errors as $field => $errorMessages) {
            $firstError[$field] = $errorMessages[0];
        }

        $response = [
            'status' => 401,
            'msg' => reset($firstError),
            'data' => null
        ];

        throw new HttpResponseException(response()->json($response));
    }
}
