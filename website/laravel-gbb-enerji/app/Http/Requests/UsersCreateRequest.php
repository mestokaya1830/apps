<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5|max:100',
            'email' => 'required|min:8|max:255',
            'password' => 'required|min:4|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Ad',
            'email' => 'Mail Adresi',
            'password' => 'Şifre',
        ];
    }
}
