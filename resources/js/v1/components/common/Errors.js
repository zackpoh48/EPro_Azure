let errors = {
    login: {
        email: "Email is required",
        rfq_id: "RFQ is required",
        password: "Password is required"
    },
    verification_screen: {
        passcode: "Passcode is required"
    },
    adminLogin: {
        email: "Email is required",
        password: "Password is required"
    },
    adminSettings: {
        soap_url: "SOAP URL is required",
        tnc_url: "TnC URL is required"
    },
    adminImport: {
        option: "Please select an option",
        file: "File is required"
    },
    registration: {
        name_of_company: "Name of company is required",
        company_reg_no: "Company Reg. no is required",
        registered_address_one: "Registered address is required",
        registered_address_two: "Registered address is required",
        mailing_address_one: "Mailing address is required",
        mailing_address_two: "Mailing address is required",
        city: "City is required",
        state: "State is required",
        zip_code: "Zip Code is required",
        country: "Country is required",
        tel_no: "Telephone No. is required",
        fax_no: "Fax No. is required",
        company_website: "Company website is required",
        email_address: "Email address is required",
        type_of_company: "Type of company is required",
        date_of_incorporation: "Date of incorporation is required",
        sst_registration_no: "SST registration No. is required",
        contact_person_one: "Contact person is required",
        designation_one: "Designation is required",
        contact_person_two: "Contact person is required",
        designation_two: "Designation is required",
        contact_person_three: "Contact person is required",
        designation_three: "Designation is required",
        annual_turnover: "Annual turnover is required",
        working_capital: "Working capital is required",
        net_worth: "Net worth is required",
        cash_bank_balance: "Cash & Bank balance is required",
        paid_up_capital: "Paid up capital is required",
        product_desc_one: "Product Description is required",
        credit_term_offered: "Credit term offered is required",
        litigation_records: "Litigation records is required",
        corruption_fraudulent_records: "Corruption & Fraudulent records is required",
        name: "Name is required",
        designation: "Designation is required",
        nric_no: "NRIC No. is required",
        date: "Date is required"
    },
    rfq: {
        rfq_id: "RFQ is required",
        delivery_date: "Delivery Date is required",
        currency: "Currency is required",
        terms: "Please accept the terms and conditions",
        vendor_quotation_no: "Supplier Quotation no is required"
    },
    rfqItems: {
        offer_qty: "Offer Qty is required",
        offer_uom: "Offer UOM is required",
        cost: "Cost is required",
        discount: "Discount is required",
        remarks: "Remarks is required"
    }
};

export default errors;
