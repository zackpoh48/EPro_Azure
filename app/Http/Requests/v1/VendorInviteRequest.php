<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class VendorInviteRequest extends FormRequest
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
            'email' => 'required',
            'person_name' => 'required',
            'company_name' => 'required',
            'vendor_regis_no' => 'required',
            'reference' => 'required',
            'passcode' => 'required|numeric|digits:6',
            'organization_unique_id' => 'required',
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
            'email.required' => 'Email is required',
            'person_name.required' => 'Person name is required',
            'company_name.required' => 'Company name is required',
            'vendor_regis_no.required' => 'Vendor registration no. is required',
            'reference.required' => 'Reference is required',
            'passcode.required' => 'Passcode is required',
            'organization_unique_id.required' => "Organization Unique ID is required"
        ];
    }
}
