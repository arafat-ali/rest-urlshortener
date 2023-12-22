<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|min:2|max:64',
            'email'           => 'required|email|min:4|max:256|unique:users',
            'password'        => 'required|min:6|max:64',
            'confirmPassword' => 'required|same:password|min:6|max:64',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Name is required!',
            'name.min' => 'Name must be between 3 to 64 characters!',
        ];
    }

    public function failedValidation(Validator $validator){
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);

    }


}
