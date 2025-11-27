<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RfqRequest extends FormRequest
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
            'date_of_rfq' => 'required',
            'priority' => 'required',
            'date_of_expiry' => 'required',
            'currency_code' => ['nullable', Rule::in(
                [
                    'MYR', 'INR'
                ]
            )],
            'quotation_no' => 'required',
            'buyer_remarks' => 'required',
            'items' => 'required',
            // 'organization_unique_id' => 'required',
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
            'date_of_rfq.required' => 'Date of RFQ is required',
            'priority.required' => 'Priority is required',
            'currency_code.string' => 'Must be string',
            'date_of_expiry.required' => 'Date of Expiry is required',
            'quotation_no.required' => 'Quotation number is required',
            'buyer_remarks.required' => 'Buyer remarks is required',
            'items.required' => 'Items is required',
            'organization_unique_id.required' => "Organization Unique ID is required"
        ];
    }
}
