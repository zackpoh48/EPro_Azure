<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            "name" => "nullable|string",
            "send_registration_email" => "nullable|boolean",
            "nav_username" => "nullable|string",
            "nav_password" => "nullable|string",
            "nav_auth" => "nullable|string",
            "nav_server" => "nullable|string",
            "nav_port" => "nullable|string",
            "nav_environment" => "nullable|string",
            "nav_company" => "nullable|string",
            "logo_url" => "nullable|string"
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (isset($this->send_registration_email)) {
            $this->merge([
                "send_registration_email" => $this->toBoolean(
                    $this->send_registration_email
                ),
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
