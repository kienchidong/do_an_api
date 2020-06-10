<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:admins,email',
            'password' => 'bail|required|min:6',
            'repassword' => 'bail|required|same:password',
            'role_id' => 'bail|required|exists:roles,id',
            'permission_id' => 'bail|required',
        ];
    }
}
