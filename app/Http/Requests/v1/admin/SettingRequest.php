<?php

namespace App\Http\Requests\v1\admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'soap_url' => 'required',
            'tnc_url' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'soap_url.required' => 'SOAP URL is required',
            'tnc_url.required' => 'TNC URL is required'
        ];
    }
}
