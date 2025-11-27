<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            // "company_reg_no" => "nullable|string",
            "registered_address_one" => "nullable|string",
            "registered_address_two" => "nullable|string",
            "mailing_address_one" => "nullable|string",
            "mailing_address_two" => "nullable|string",
            "city" => "nullable|string",
            "state" => "nullable|string",
            "zip_code" => "nullable|string",
            "country" => "nullable|string",
            "tel_no" => "nullable|string",
            "fax_no" => "nullable|string",
            "company_website" => "nullable|string",
            "email" =>
                "nullable|email|unique:users,email," .
                $this->user()->id .
                ",id",
            "date_of_incorporation" => "nullable|string",
            "sst_registration_no" => "nullable|string",
            "contact_person_one" => "nullable|string",
            "designation_one" => "nullable|string",
            "contact_person_two" => "nullable|string",
            "designation_two" => "nullable|string",
            "contact_person_three" => "nullable|string",
            "designation_three" => "nullable|string",
            "bank_name" => "nullable|string|max:50",
            "swift_code" => "nullable|string|max:20",
            "bank_branch" => "nullable|string|max:20",
            "bank_account_no" => "nullable|string|max:30",
            "bank_address_one" => "nullable|string",
            "bank_address_two" => "nullable|string",
            "bank_statement" => "nullable|array",
            "bank_statement.*" =>
                "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            // "product_desc_one" => "nullable|string",
            // "product_desc_two" => "nullable|string",
            // "product_desc_three" => "nullable|string",
            // "product_desc_four" => "nullable|string",
            // "product_desc_five" => "nullable|string",
            // "product_desc_six" => "nullable|string",
            "type_of_company" => [
                "nullable",
                Rule::in([
                    "Sole Proprietor",
                    "Partnership",
                    "Private Limited",
                    "Public Listed",
                    "Others (Please Specify)",
                ]),
            ],
            "type_of_company_other" => "nullable|string",
            "latest_business_registration" => "nullable|array",
            "latest_business_registration.*" =>
                "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            "borang_p" => "nullable|array",
            "borang_p.*" =>
                "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            "form_49" => "nullable|array",
            "form_49.*" => "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            "photocopy_ic" => "nullable|array",
            "photocopy_ic.*" =>
                "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            // "products_0" =>
            //     "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            // "products_1" =>
            //     "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            // "products_2" =>
            //     "mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240",
            "credit_term_offered" => "nullable|string",
            "credit_term_offered_other" => "nullable|string",
            // "anti_bribery_acknowledgement" => "nullable|string",

            "vendor_type" => ["nullable", Rule::in(["Local", "Foreign"])],
            "tin" => "nullable|string|max:20",
            "msic_code" => "nullable|string|max:20",
            "id_type" => [
                "nullable",
                Rule::in(["NRIC", "PASSPORT", "BRN", "ARMY"]),
            ],
            "id_value" => "nullable|string",
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
            // "company_reg_no.string" => "Must be string",
            "registered_address_one.string" => "Must be string",
            "registered_address_two.string" => "Must be string",
            "mailing_address_one.string" => "Must be string",
            "mailing_address_two.string" => "Must be string",
            "city.string" => "Must be string",
            "state.string" => "Must be string",
            "zip_code.string" => "Must be string",
            "country.string" => "Must be string",
            "tel_no.string" => "Must be string",
            "fax_no.string" => "Must be string",
            "company_website.string" => "Must be string",
            "email.email" => "Must be email",
            "email.unique" => "Email already exists",
            "date_of_incorporation.string" => "Must be string",
            "sst_registration_no.string" => "Must be string",
            "contact_person_one.string" => "Must be string",
            "designation_one.string" => "Must be string",
            "contact_person_two.string" => "Must be string",
            "designation_two.string" => "Must be string",
            "contact_person_three.string" => "Must be string",
            "designation_three.string" => "Must be string",
            "bank_name.string" => "Must be string",
            "swift_code.string" => "Must be string",
            "bank_branch.string" => "Must be string",
            "bank_account_no.string" => "Must be string",
            "bank_statement.array" => "Must be array",
            "bank_statement.mimes" => "Please upload file",
            "bank_statement.max" =>
                "File size should not be greater than 10 MB",
            // "product_desc_one.string" => "Must be string",
            // "product_desc_two.string" => "Must be string",
            // "product_desc_three.string" => "Must be string",
            // "product_desc_four.string" => "Must be string",
            // "product_desc_five.string" => "Must be string",
            // "product_desc_six.string" => "Must be string",
            "type_of_company.string" => "Must be string",
            "type_of_company_other.string" => "Must be string",
            "latest_business_registration.array" => "Must be array",
            "latest_business_registration.mimes" => "Please upload file",
            "latest_business_registration.max" =>
                "File size should not be greater than 10 MB",
            "borang_p.array" => "Must be array",
            "borang_p.mimes" => "Please upload file",
            "borang_p.max" => "File size should not be greater than 10 MB",
            "form_49.array" => "Must be array",
            "form_49.mimes" => "Please upload file",
            "form_49.max" => "File size should not be greater than 10 MB",
            "photocopy_ic.array" => "Must be array",
            "photocopy_ic.mimes" => "Please upload file",
            "photocopy_ic.max" => "File size should not be greater than 10 MB",

            // "products_0.mimes" => "Please upload file",
            // "products_1.mimes" => "Please upload file",
            // "products_2.mimes" => "Please upload file",
            // "products_0.max" => "File size should not be greater than 10 MB",
            // "products_1.max" => "File size should not be greater than 10 MB",
            // "products_2.max" => "File size should not be greater than 10 MB",
            "credit_term_offered.string" => "Must be string",
            "credit_term_offered_other.string" => "Must be string",
            // "anti_bribery_acknowledgement.string" => "Must be string",

            "vendor_type.in" => "Must be either Local or Foreign.",
            "tin.max" => "Must not exceed 20 characters.",
            "tin.string" => "Must be a valid string.",
            "msic_code.max" => "Must not exceed 20 characters.",
            "msic_code.string" => "Must be a valid string.",
            "id_type.in" => "Must be either NRIC, PASSPORT, BRN or ARMY",
            "id_value.string" => "Must be a valid string.",
        ];
    }
}
