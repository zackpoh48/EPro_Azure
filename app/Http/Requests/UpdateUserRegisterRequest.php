<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRegisterRequest extends FormRequest
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
            "activated" => "bail|boolean|nullable",
            // "email" =>
            //     "bail|email|nullable|unique:users,email," .
            //     $this->uuid .
            //     ",unique_id",
            // "vendor_no" => "bail|string|nullable",
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
            "activated.boolean" => "Must be integer!",
            // "email.email" => "Must be email!",
            // "vendor_no.string" => "Must be string!",
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (isset($this->activated)) {
            $this->merge([
                "activated" => $this->toBoolean($this->activated),
            ]);
        }
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
