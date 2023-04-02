<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'id'=> 'required|exists:users',
            'email' => [Rule::unique('users')->ignore($this->id)],
            'password'=>'min:8',
        ];
    }


    public function messages(): array
    {
        return [
            'id.exists' => 'User Not Found, Try To Enter another id',
        ];
    }
}
