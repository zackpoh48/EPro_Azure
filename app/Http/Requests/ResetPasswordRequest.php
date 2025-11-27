<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
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
            // "vendor_no" => "bail|required|string",
            // "email" => [
            //     "bail",
            //     "required",
            //     "email",
            //     Rule::exists("users")->where(function ($query) {
            //         return $query
            //             ->where("email", $this->email)
            //             ->where("vendor_no", $this->vendor_no);
            //     }),
            "email" => "required|email|exists:users,registered_email_address",
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
            // "vendor_no.string" => "Must be string",
            "email.email" => "Must be email",
            // "vendor_no.required" => "Vendor no. is required!",
            "email.required" => "Email is required!",
            "email.exists" => "Given email address does not exists!",
            // "Given email address and vendor no. does not exists",
        ];
    }
}
