<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'sometimes|string|max:100|unique:users,username,' . $this->user()->id,
            'email' => 'sometimes|email|max:100|unique:users,email,' . $this->user()->id,
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'phone' => 'sometimes|string|max:20',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response( [
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
