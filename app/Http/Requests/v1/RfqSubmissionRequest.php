<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RfqSubmissionRequest extends FormRequest
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
            'rfq_id' => 'exists:rfqs,rfq_id',
            'date_of_rfq' => 'nullable|date',
            'priority' => 'string',
            'date_of_expiry' => 'nullable|date',
            'quotation_no' => 'string',
            'buyer_remarks' => 'nullable|string',
            'tender_title' => 'nullable|string',
            'delivery_date' => 'nullable|string',
            'offer_validity' => 'nullable|string',
            'quality' => 'nullable|string',
            'pay_terms' => 'nullable|string',
            'advance_paid' => 'nullable|string',
            'vendor_no' => 'required|string',
            'vendor_quotation_no' => 'nullable|string',
            'currency' => ['nullable', Rule::in(['MYR', 'USD'])],
            'supplier_remarks' => 'nullable|string',
            'delivery_location' => 'nullable|string',
            'status' => [Rule::in([0, 1])],
            'items' => 'array',
            'items.*.item_description' => 'nullable|string',
            'items.*.item_no' => 'nullable|string',
            'items.*.item_expected_delivery' => 'nullable|string',
            'items.*.quality' => ['nullable', Rule::in(['high', 'medium', 'low'])],
            'items.*.offer_qty' => 'nullable|numeric',
            'items.*.cost' => 'nullable|string',
            'items.*.discount' => 'nullable|string',
            'items.*.offer_uom' => 'nullable|string',
            'items.*.remarks' => 'nullable|string',
            'quotation_0' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'quotation_1' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'quotation_2' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
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
            'rfq_id.exists' => 'Must be present in rfqs',
            'date_of_rfq.date' => 'Must be date',
            'priority.string' => 'Must be string',
            'date_of_expiry.date' => 'Must be date',
            'quotation_no.string' => 'Must be string',
            'buyer_remarks.string' => 'Must be string',
            'tender_title.string' => 'Must be string',
            'delivery_date.date' => 'Must be date',
            'offer_validity.string' => 'Must be string',
            'quality.string' => 'Must be string',
            'pay_terms.string' => 'Must be string',
            'advance_paid.string' => 'Must be string',
            'vendor_no.required' => "Vendor no is required",
            // 'pay_mode' => ,
            // 'currency' => ,
            'supplier_remarks' => 'Must be string',
            'delivery_location' => 'Must be string',
            'items.*.item_description.string' => 'Must be string',
            'items.*.item_no.string' => 'Must be number',
            'items.*.item_expected_delivery.string' => 'Must be string',
            'items.*.offer_qty.numeric' => 'Must be number',
            'items.*.cost.string' => 'Must be string',
            'items.*.discount.string' => 'Must be string',
            'items.*.offer_uom.string' => 'Must be string',
            'items.*.remarks.string' => 'Must be string',
        ];
    }
}
