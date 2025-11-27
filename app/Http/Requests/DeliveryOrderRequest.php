<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryOrderRequest extends FormRequest
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
            "delivery_order_no" => [
                "bail",
                "string",
                "nullable",
                Rule::unique("delivery_orders")->where(function ($query) {
                    return $query
                        ->where("delivery_order_no", $this->delivery_order_no)
                        ->where("is_complete", 1);
                }),
            ],
            // "invoice" => "bail|boolean|nullable",
            "delivery_order_date" => "bail|nullable|date",
            "invoice_no" => "bail|string|nullable",
            "invoice_date" => "bail|nullable|date",
            "order_date" => "bail|nullable|date",
            "expected_receipt_date" => "bail|nullable|date",
            "amount_including_vat" => "bail|nullable|numeric",
            "currency_code" => "bail|nullable|string",
            "is_complete" => "bail|required|boolean",
            "delivery_attachments" => "bail|array|nullable",
            "delivery_attachments.*" =>
                "bail|mimes:pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png",
            "invoice_attachments" => "bail|array|nullable",
            "invoice_attachments.*" =>
                "bail|mimes:pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png",
            "delivery_order_lines" => "bail|array|nullable",
            "delivery_order_lines.*.line_no" => "bail|nullable|string",
            "delivery_order_lines.*.type" => "bail|nullable|string",
            "delivery_order_lines.*.no" => "bail|nullable|string",
            "delivery_order_lines.*.description" => "bail|nullable|string",
            "delivery_order_lines.*.location_code" => "bail|nullable|string",
            "delivery_order_lines.*.quantity" => "bail|nullable|numeric",
            // "delivery_order_lines.*.uom" => "bail|nullable|string",
            "delivery_order_lines.*.unit_cost_including_sst" =>
                "bail|nullable|numeric",
            "delivery_order_lines.*.amount_including_sst" =>
                "bail|nullable|numeric",
            "delivery_order_lines.*.quantity_to_deliver" =>
                "bail|nullable|numeric",
            "delivery_order_lines.*.quantity_delivered" =>
                "bail|nullable|numeric",
            // "delivery_order_lines.*.quantity_to_invoice" =>
            //     "bail|nullable|numeric",
            "delivery_order_lines.*.quantity_invoiced" =>
                "bail|nullable|numeric",
            "delivery_order_lines.*.deliver_with_amount" =>
                "bail|nullable|string",
            "delivery_order_lines.*.amount_to_deliver_including_sst" =>
                "bail|nullable|numeric",
            "delivery_order_lines.*.amount_delivered" =>
                "bail|nullable|numeric",
            "outstanding_quantity" => "bail|nullable|numeric",
            "outstanding_amount" => "bail|nullable|numeric",
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
            "delivery_order_no.string" => "Must be string!",
            "delivery_order_date.date" => "Must be date!",
            "invoice_date.date" => "Must be date!",
            "invoice.required" => "Invoice is required!",
            "invoice_no.string" => "Must be string!",
            "invoice_no.required_if" =>
                "Invoice no. is required if invoice is true",
            "is_complete.required" => "Boolean is_complete is required!",
            "is_complete.boolean" => "Must be boolean!",
            "delivery_attachments.array" => "Must be array!",
            "delivery_attachments.mimes" =>
                "Must be of pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png type",
            "invoice_attachments.array" => "Must be array!",
            "invoice_attachments.mimes" =>
                "Must be of pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png type",
            "delivery_order_lines.array" => "Must be array!",
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            // "invoice" => $this->toBoolean($this->invoice),
            "is_complete" => $this->toBoolean($this->is_complete),
        ]);
    }

    /**
     * Convert to boolean
     *
     * @param $booleable
     * @return boolean
     */
    private function toBoolean($booleable)
    {
        return filter_var(
            $booleable,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );
    }
}
