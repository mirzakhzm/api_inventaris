<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            "username" => ["required", "string", "max:100", "unique:users,username"],
            "email" => ["required", "string", "email", "max:100", "unique:users,email"],
            "first_name" => ["required", "string", "max:100"],
            "last_name" => ["required", "string", "max:100"],
            "phone" => ["required", "string", "max:15"],
            "role" => ["required" ,"string", "in:pegawai,pemilik"],
            "password" => ["required", "string", "min:8", "max:100"],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response( [
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
