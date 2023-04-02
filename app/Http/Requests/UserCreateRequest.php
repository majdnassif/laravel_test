<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name  is required',
            'email.unique' => 'the email is already exist',
        ];
    }
}
