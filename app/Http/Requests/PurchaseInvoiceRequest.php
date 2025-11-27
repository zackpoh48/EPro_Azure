<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "description" => "nullable|string",
            "location_name" => "nullable|string",
            "quantity" => "nullable|numeric",
            "uom" => "nullable|string",
            "unit_cost_incl_sst" => "nullable|string",
            "amount_incl_sst" => "nullable|string",
            "delivery_order_no" => "nullable|string",
            "bill_attachments" => "bail|array|nullable",
            "bill_attachments.*" =>
                "bail|mimes:pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png|max:5048",
        ];
    }
}
