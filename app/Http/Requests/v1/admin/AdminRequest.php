<?php

namespace App\Http\Requests\v1\admin;

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
            'file' => 'required|file|mimes:csv'
        ];
    }
    public function messages()
    {
        return [
            'file' => 'File Should be in csv format'
        ];
    }
}
