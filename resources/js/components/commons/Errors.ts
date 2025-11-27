const errors = {
    login: {
        email: "Email is required",
        rfq_id: "RFQ is required",
        password: "Password is required",
    },
    verification_screen: {
        passcode: "Passcode is required",
    },
    adminLogin: {
        email: "Email is required",
        password: "Password is required",
    },
    adminSettings: {
        soap_url: "SOAP URL is required",
        tnc_url: "TnC URL is required",
    },
    adminImport: {
        option: "Please select an option",
        file: "File is required",
    },
    registration: {
        company_name: "Name of company is required",
        company_reg_no: "Company Reg. no is required",
        registered_address_one: "Registered address is required",
        registered_address_two: "Registered address is required",
        mailing_address_one: "Mailing address is required",
        // mailing_address_two: "Mailing address is required",
        // city: "City is required",
        // state: "State is required",
        // zip_code: "Zip Code is required",
        // country: "Country is required",
        tel_no: "Telephone No. is required",
        // fax_no: "Fax No. is required",
        // company_website: "Company website is required",
        // email: "Web portal email address is required",
        username: "Web portal username is required",
        registered_email_address: "Registered email address is required",
        type_of_company: "Type of company is required",
        // date_of_incorporation: "Date of incorporation is required",
        sst_registration_no: "SST registration No. is required",
        contact_person_one: "Contact person is required",
        // designation_one: "Designation is required",
        // contact_person_two: "Contact person is required",
        // designation_two: "Designation is required",
        // contact_person_three: "Contact person is required",
        // designation_three: "Designation is required",
        bank_name: "Bank name is required",
        swift_code: "Swift code is required",
        bank_branch: "Bank branch is required",
        bank_account_no: "Bank account no is required",
        // cash_bank_balance: "Cash & Bank balance is required",
        // product_desc_one: "Product Description is required",
        credit_term_offered: "Credit term offered is required",
        // litigation_records: "Litigation records is required",
        // anti_bribery_acknowledgement:
        //     "Anti bribery acknowledgement is required",
        // corruption_fraudulent_records:
        //     "Corruption & Fraudulent records is required",
        // name: "Name is required",
        // designation: "Designation is required",
        // nric_no: "NRIC No. is required",
        // date: "Date is required",

        vendor_type: "Vendor type is required",
        tin: "TIN is required",
        msic_code: "MSIC code is required",
        id_type: "ID type is required",
        id_value: "ID value is required",
    },
    registration2: {
        name_of_company: "Name of company is required",
        company_reg_no: "Company Reg. no is required",
        registered_address_one: "Registered address is required",
        // registered_address_two: "Registered address is required", //optional
        mailing_address_one: "Mailing address is required",
        // mailing_address_two: "Mailing address is required", //optional
        mailing_address_city: "Mailing address cty is required",
        mailing_address_state: "Mailing address state is required",
        mailing_address_zip_code: "Mailing address zip code is required",
        mailing_address_country: "Mailing address country is required",
        vendor_type: "Vendor Type is required",
        account_type: "Account Type is required",
        msic_code: "MSIC code is required",
        id_type: "ID Type is required",
        id_value: "ID Value is required",
        // tin: "Company TIN No is required",
        city: "City is required",
        state: "State is required",
        zip_code: "Zip Code is required",
        country: "Country is required",
        tel_no: "Telephone No. is required",
        // fax_no: "Fax No. is required", //optional
        // company_website: "Company website is required", //optional
        // email_address: "Web portal email address is required", //optional
        // registered_email_address: "Registered email address is required",
        type_of_company: "Type of company is required",
        date_of_incorporation: "Date of incorporation is required",
        // sst_registration_no: "SST registration No. is required", //optional
        contact_person_one: "Contact person is required",
        designation_one: "Designation is required",
        // contact_person_two: "Contact person is required", //optional
        // designation_two: "Designation is required", //optional
        // contact_person_three: "Contact person is required", //optional
        // designation_three: "Designation is required", //optional
        bank_name: "Bank name is required",
        // swift_code: "Swift code is required", //optional
        // bank_branch: "Bank branch is required", //optional
        bank_account_no: "Bank account no is required",
        cash_bank_balance: "Cash & Bank balance is required",
        // product_desc_one: "Product Description is required", //Mandatory check removed
        credit_term_offered: "Credit term offered is required",
        litigation_records: "Litigation records is required",
        // anti_bribery_acknowledgement:
        //     "Anti bribery acknowledgement is required",
        corruption_fraudulent_records:
            "Corruption & Fraudulent records is required",
        name: "Name is required",
        designation: "Designation is required",
        nric_no: "NRIC No. is required",
        date: "Date is required",
    },
    rfq: {
        rfq_id: "RFQ is required",
        delivery_date: "Delivery Date is required",
        currency: "Currency is required",
        terms: "Please accept the terms and conditions",
        vendor_quotation_no: "Supplier Quotation no is required",
    },
    rfqItems: {
        offer_qty: "Offer Qty is required",
        offer_uom: "Offer UOM is required",
        cost: "Cost is required",
        discount: "Discount is required",
        remarks: "Remarks is required",
    },
};
export default errors;
