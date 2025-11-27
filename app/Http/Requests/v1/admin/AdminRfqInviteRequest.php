<?php

namespace App\Http\Requests\v1\admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRfqInviteRequest extends FormRequest
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
            'rfq_id' => 'required',
            'user_ids' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'rfq_id.required' => 'RFQ Id required',
            'user_ids.required' => "User Ids required"
        ];
    }
}
