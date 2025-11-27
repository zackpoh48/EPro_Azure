<?php

namespace App\Http\Requests\v1\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'registered_email_address' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}
