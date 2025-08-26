<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user') ?? $this->route('id') ?? null;

        return [
            'user_name' => 'required|string|max:255',
            'user_email' => [
                'required','email','max:255',
                Rule::unique('users','user_email')->ignore($userId,'user_id'),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'user_mobile_no' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,user,employee,sub_user',
            'user_status' => 'nullable|in:inactive,active,blocked',
            'parent_id' => 'nullable|exists:users,user_id',
        ];
    }
}