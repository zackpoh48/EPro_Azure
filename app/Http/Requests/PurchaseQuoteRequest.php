<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseQuoteRequest extends FormRequest
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
            "purchase_quote_no" => [
                "bail",
                "string",
                "nullable",
                // Rule::unique("purchase_quotes")->where(function ($query) {
                //     return $query
                //         ->where("purchase_quote_no", $this->purchase_quote_no)
                //         ->where("is_complete", 1);
                // }),
            ],
            "date" => "bail|nullable|date",
            "vendor_quote_no" => "bail|string|nullable",
            "quotation_date" => "bail|nullable|date",
            "currency" => "bail|nullable|string",
            "amount_including_sst" => "bail|nullable|numeric",
            "reference" => "bail|string|nullable",
            "last_line_no" => "bail|nullable|numeric",
            "is_complete" => "bail|required|boolean",
            "support_attachments" => "bail|array|nullable",
            "support_attachments.*" =>
                "bail|mimes:pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png",
            "purchase_quote_lines" => "bail|array|nullable",
            "purchase_quote_lines.*.line_no" => "bail|nullable|string",
            "purchase_quote_lines.*.type" => "bail|nullable|string",
            "purchase_quote_lines.*.description" => "bail|nullable|string",
            "purchase_quote_lines.*.quantity" => "bail|nullable|numeric",
            "purchase_quote_lines.*.unit_of_measure_code" =>
                "bail|nullable|string",
            "purchase_quote_lines.*.direct_unit_cost" =>
                "bail|nullable|numeric",
            "purchase_quote_lines.*.line_amount" => "bail|nullable|numeric",
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
            "purchase_quote_no.string" => "Must be string!",
            "date.date" => "Must be date!",
            "vendor_quote_no.string" => "Must be string!",
            "quotation_date.date" => "Must be date!",
            "currency.string" => "Must be string!",
            "reference" => "Must be string!",
            "is_complete.required" => "Boolean is_complete is required!",
            "is_complete.boolean" => "Must be boolean!",
            "support_attachments.array" => "Must be array!",
            "support_attachments.mimes" =>
                "Must be of pdf,csv,xls,xlsx,doc,docx,jpg,jpeg,png type",
            "purchase_quote_lines.array" => "Must be array!",
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
