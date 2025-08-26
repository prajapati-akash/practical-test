<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        // Authorization checked in controller / middleware; allow here
        return true;
    }

    public function rules()
    {
        return [
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255|unique:users,user_email',
            'password' => 'required|string|min:8|confirmed',
            'user_mobile_no' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,user,employee,sub_user',
            'parent_id' => 'nullable|exists:users,user_id',
        ];
    }
}