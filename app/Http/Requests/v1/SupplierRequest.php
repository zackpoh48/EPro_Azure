<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
        $type = $this->query('type');
        return [
            'name_of_company' => 'required|string',
            'company_reg_no' => 'required|string',
            'registered_address_one' => $type !== 'save' ? 'required|string' : 'nullable|string',
            'registered_address_two' => 'nullable|string',
            'mailing_address_one' => $type !== 'save' ? 'required|string' : 'nullable|string',
            'mailing_address_two' => 'nullable|string',
            'vendor_type'=>$type !== 'save' ? 'required|string|in:Local,Foreign' : 'nullable|string|in:Local,Foreign',
            'account_type'=>$type !== 'save' ? 'required|string|in:Company,Individual' : 'nullable|string|in:Company,Individual',
            'msic_code'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'id_type'=>$type !== 'save' ? 'required|string|in:BRN,NRIC,PASSPORT,ARMY' : 'nullable|string|in:BRN,NRIC,PASSPORT,ARMY',
            'id_value'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'tin' => $type !== 'save' ? 'required_if:vendor_type,Local|string' : 'nullable|string',
            'mailing_address_city'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'mailing_address_state'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'mailing_address_country'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'mailing_address_zip_code'=>$type !== 'save' ? 'required|string' : 'nullable|string',
            'mailing_address_same_as_registered_address'=>'nullable',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string',
            'tel_no' => 'nullable|string',
            'fax_no' => 'nullable|string',
            'company_website' => 'nullable|string',
            'email_address' => 'nullable|email',
            'date_of_incorporation' => 'nullable|string',
            'sst_registration_no' => 'nullable|string',
            'contact_person_one' => 'nullable|string',
            'designation_one' => 'nullable|string',
            'contact_person_two' => 'nullable|string',
            'designation_two' => 'nullable|string',
            'contact_person_three' => 'nullable|string',
            'designation_three' => 'nullable|string',
            'annual_turnover' => ['nullable', 'numeric', 'min:0', 'max:99999999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'working_capital' => ['nullable', 'numeric', 'min:-99999999999999.99', 'max:99999999999999.99'],
            'net_worth' => ['nullable', 'numeric', 'min:-99999999999999.99', 'max:99999999999999.99'],
            'cash_bank_balance' => ['nullable', 'numeric', 'min:0', 'max:99999999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'paid_up_capital' => ['nullable', 'numeric', 'min:0', 'max:99999999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'product_desc_one' => 'nullable|string',
            'product_desc_two' => 'nullable|string',
            'product_desc_three' => 'nullable|string',
            'product_desc_four' => 'nullable|string',
            'product_desc_five' => 'nullable|string',
            'product_desc_six' => 'nullable|string',
            'type_of_company' => ['nullable', Rule::in(
                [
                    'Sole Proprietor', 'Partnership', 'Private Limited', 'Public Listed', 'Others (Please Specify)'
                ]
            )],
            'type_of_company_other' => 'nullable|string',
            'certification' => 'nullable|string',
            'certification_other' => 'nullable|string',
            'certificates_0' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'certificates_1' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'certificates_2' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'profile_0' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'profile_1' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'profile_2' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'products_0' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'products_1' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'products_2' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'bank_statement_0' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'bank_statement_1' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'bank_statement_2' => 'mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx|max:10240',
            'credit_term_offered' => 'nullable|string',
            'credit_term_offered_other' => 'nullable|string',
            'litigation_records' => 'nullable|string',
            'litigation_records_other' => 'nullable|string',
            'corruption_fraudulent_records' => 'nullable|string',
            'corruption_fraudulent_records_other' => 'nullable|string',
            'name' => 'nullable|string',
            'designation' => 'nullable|string',
            'nric_no' => 'nullable|string',
            'date' => 'nullable|string',
            'bank_name'=> $type !== 'save' ? 'required|string' : 'nullable|string',
            'swift_code'=> 'nullable|string',
            'bank_branch'=> 'nullable|string',
            'bank_account_no'=> $type !== 'save' ? 'required|string' : 'nullable|string',
            'bank_address_one'=> 'nullable|string',
            'bank_address_two'=> 'nullable|string',
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
            'name_of_company.required' => 'Name of company is required',
            'name_of_company.string' => 'Must be string',
            'company_reg_no.required' => 'Company Reg. No is required',
            'company_reg_no.string' => 'Must be string',
            'registered_address_one.required' => 'Registered address one is required',
            'registered_address_one.string' => 'Must be string',
            'registered_address_two.string' => 'Must be string',
            'mailing_address_one.required' => 'Mailing address one is required',
            'mailing_address_one.string' => 'Must be string',
            'mailing_address_two.string' => 'Must be string',
            'vendor_type.required' => 'Vendor type is required',
            'vendor_type.string'   => 'Vendor type must be a string',
            'vendor_type.in'       => 'Vendor type must be either Local or Foreign',
            'account_type.required' => 'Account type is required',
            'account_type.string'   => 'Account type must be a string',
            'account_type.in'       => 'Account type must be either Company or Individual',
            'msic_code.required' => 'MSIC code is required',
            'msic_code.string'     => 'MSIC code must be a string',
            'id_type.required' => 'ID type is required',
            'id_type.string'   => 'ID type must be a string',
            'id_type.in'       => 'ID type must be one of: BRN, NRIC, PASSPORT, ARMY',
            'id_value.required' => 'ID value is required',
            'tin.required' => 'TIN is required',
            'tin.string'   => 'TIN must be a string',
            'mailing_address_city' => 'Mailing address cty is required',
            'mailing_address_state' => 'Mailing address state is required',
            'mailing_address_country.required' => 'Mailing address country is required',
            'mailing_address_zip_code' => 'Mailing address zip code is required',
            'city.string' => 'Must be string',
            'state.string' => 'Must be string',
            'zip_code.string' => 'Must be string',
            'country.string' => 'Must be string',
            'tel_no.string' => 'Must be string',
            'fax_no.string' => 'Must be string',
            'company_website.string' => 'Must be string',
            'email_address.string' => 'Must be string',
            'date_of_incorporation.string' => 'Must be string',
            'sst_registration_no.string' => 'Must be string',
            'contact_person_one.string' => 'Must be string',
            'designation_one.string' => 'Must be string',
            'contact_person_two.string' => 'Must be string',
            'designation_two.string' => 'Must be string',
            'contact_person_three.string' => 'Must be string',
            'designation_three.string' => 'Must be string',
            'annual_turnover.regex' => 'Must be number',
            'working_capital.regex' => 'Must be number',
            'net_worth.regex' => 'Must be number',
            'cash_bank_balance.regex' => 'Must be number',
            'paid_up_capital.regex' => 'Must be number',
            'product_desc_one.string' => 'Must be string',
            'product_desc_two.string' => 'Must be string',
            'product_desc_three.string' => 'Must be string',
            'product_desc_four.string' => 'Must be string',
            'product_desc_five.string' => 'Must be string',
            'product_desc_six.string' => 'Must be string',
            'type_of_company.string' => 'Must be string',
            'type_of_company_other.string' => 'Must be string',
            'certification.string' => 'Must be string',
            'certification_other.string' => 'Must be string',
            'certificates_0.mimes' => 'Please upload file',
            'certificates_1.mimes' => 'Please upload file',
            'certificates_2.mimes' => 'Please upload file',
            'profile_0.mimes' => 'Please upload file',
            'profile_1.mimes' => 'Please upload file',
            'profile_2.mimes' => 'Please upload file',
            'products_0.mimes' => 'Please upload file',
            'products_1.mimes' => 'Please upload file',
            'products_2.mimes' => 'Please upload file',
            'certificates_0.max' => 'File size should not be greater than 10 MB',
            'certificates_1.max' => 'File size should not be greater than 10 MB',
            'certificates_2.max' => 'File size should not be greater than 10 MB',
            'profile_0.max' => 'File size should not be greater than 10 MB',
            'profile_1.max' => 'File size should not be greater than 10 MB',
            'profile_2.max' => 'File size should not be greater than 10 MB',
            'products_0.max' => 'File size should not be greater than 10 MB',
            'products_1.max' => 'File size should not be greater than 10 MB',
            'products_2.max' => 'File size should not be greater than 10 MB',
            'credit_term_offered.string' => 'Must be string',
            'credit_term_offered_other.string' => 'Must be string',
            'litigation_records.string' => 'Must be string',
            'litigation_records_other.string' => 'Must be string',
            'corruption_fraudulent_records.string' => 'Must be string',
            'corruption_fraudulent_records_other.string' => 'Must be string',
            'name.string' => 'Must be string',
            'designation.string' => 'Must be string',
            'nric_no.string' => 'Must be string',
            'date.string' => 'Must be string',
            'bank_name.required'=> 'Bank name is required', 
            'swift_code.required'=> 'Swift code is required', 
            'bank_branch.required'=> 'Bank branch is required', 
            'bank_account_no.required'=> 'Bank account number is required',
        ];
    }
}
