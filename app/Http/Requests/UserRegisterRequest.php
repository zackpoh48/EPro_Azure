<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
            "vendor_no" => "bail|required|string",
            "company_name" => "bail|required|string",
            "name" => "bail|required|string",
            "type" => "bail|nullable|integer",
            "company_reg_no" => "bail|required|string",
            "registered_email_address" => "bail|email|required",
            // "email" => "bail|required",
            // "email" => [
            //     "bail",
            //     "required",
            //     Rule::unique("users")->where(function ($query) {
            //         return $query
            //             ->where("email", $this->email)
            //             ->where("vendor_no", $this->vendor_no);
            //     }),
            // ],
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
            "vendor_no.string" => "Must be string",
            "company_name.string" => "Must be string",
            "name.string" => "Must be string",
            // "email.email" => "Must be email",
            "vendor_no.required" => "Vendor no. is required!",
            "company_name.required" => "Company name is required!",
            "name.required" => "Name is required!",
            // "email.required" => "Email is required!",
            // "email.unique" =>
            //     "Given email address with vendor no. already exists!",
            // "email.unique" => "Given email address already exists!",
            "type.integer" => "Must be number!",
            "company_reg_no.string" => "Must be string!",
            "company_reg_no.required" => "Company reg no is required!",
        ];
    }
}
