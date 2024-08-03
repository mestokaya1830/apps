<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Ad',
        ];
    }
}
