<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            // "email" => "bail|required|exists:users,email",
            "username" => "bail|required|exists:users,username",
            // "vendor_no" => [
            //     "bail",
            //     "required",
            //     Rule::exists("users")->where(function ($query) {
            //         return $query
            //             ->where("email", $this->email)
            //             ->where("vendor_no", $this->vendor_no);
            //     }),
            // ],
            "password" => "bail|required",
            "g-recaptcha-response" => "required|recaptcha",
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
            // "email.required" => "Email is required!",
            // "email.exists" => "Given email address does not exists!",
            "username.required" => "Username is required!",
            "username.exists" => "Given username does not exists!",
            // "vendor_no.required" => "Vendor no. is required!",
            // "vendor_no.exists" =>
            //     "Given email address with vendor no. does not exists!",
            "password.required" => "Password is required!",
            "g-recaptcha-response.recaptcha" => "Captcha verification failed!",
            "g-recaptcha-response.required" => "Please complete the captcha!",
        ];
    }
}
