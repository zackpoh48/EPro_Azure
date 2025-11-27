<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class RfqMultipleInviteRequest extends FormRequest
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
            'rfq_id' => 'required',
            'vendors' => 'required|array',
            'vendors.*.email' => 'required',
            'vendors.*.person_name' => 'required',
            'vendors.*.company_name' => 'required',
            'vendors.*.reference' => 'required',
            'vendors.*.vendor_regis_no' => 'required',
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
            'rfq_id.required' => 'RFQ is required',
            'vendors.required' => 'Vendor is required',
            'vendors.*.email' => 'required',
            'vendors.*.person_name' => 'required',
            'vendors.*.company_name' => 'required',
            'vendors.*.reference' => 'required',
            'vendors.*.vendor_regis_no' => 'required',
        ];
    }
}
