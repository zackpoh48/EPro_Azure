<?php

namespace App\Services;

use stdClass;

class VendorRegisterSoapService
{
	/*
    |--------------------------------------------------------------------------
    | Vendor Register Soap Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from admin controller
    |
    */
	
	/**
	 * @param VendorRegisterRequest $supplier
	 * Stores vendor Register data in the Business Central system tables
	 * @return JSON
	 */
	public function registerVendorOnBusinessCentral($supplier)
	{
		$value = $supplier;
		return null;
	}

	private function prepareBusinessCentralRequest($supplier) : stdClass {
		$value = $supplier;
		$cert = explode(',', $value->certification);
		$personName = $value->vendorInfo->person_name;
		$status = 'Registered';
		$vendorRegisNo = $value->vendorInfo->vendor_regis_no;
		$iso9001 = in_array('ISO 9001', $cert) ? 'Yes' : 'No';
		$iso14001 = in_array('ISO-14001', $cert) ? 'Yes' : 'No';
		$iso45001 = in_array('OHSAS 18001 / ISO 45001', $cert) ? 'Yes' : 'No';
		$iso37001 = in_array('ISO 37001', $cert) ? 'Yes' : 'No';
		$otherSpecify = in_array('other', $cert) ? 'Yes' : 'No';
		$otherCertificate = isset($value->certification_other) ? 'Yes' : 'No';
		$companyArr = explode(';', $value->company_profile_files);
		$company_profile_files = "";

		foreach ($companyArr as $comp) {
			$linkExplode = explode('storage/', $comp);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$company_profile_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$company_attachment = trim($company_profile_files, '|');
		$encoded_company_attachment = str_replace(' ', '%20', $company_attachment);

		$productArr = explode(';', $value->product_files);
		$product_files = "";

		foreach ($productArr as $prod) {
			$linkExplode = explode('storage/', $prod);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$product_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$product_attachment = trim($product_files, '|');
		$encoded_product_attachment = str_replace(' ', '%20', $product_attachment);

		$certificateArr = explode(';', $value->certification_files);
		$certification_files = "";

		foreach ($certificateArr as $cert) {
			$linkExplode = explode('storage/', $cert);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$certification_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$certificate_attachment = trim($certification_files, '|');
		$encoded_certificate_attachment = str_replace(' ', '%20', $certificate_attachment);
		$productCatalogue = explode('storage/', $value->product_catalogue);
		$prodcatAttachment = $productCatalogue[count($productCatalogue) - 1];
		$encoded_prodcatAttachment = str_replace(' ', '%20', $prodcatAttachment);

		$declaration_by_supplier = explode('storage/', $value->declaration_by_supplier);
		$declarationSupplierAttachment = $declaration_by_supplier[count($declaration_by_supplier) - 1];
		$encoded_declarationSupplierAttachment = str_replace(' ', '%20', $declarationSupplierAttachment);

		$supplier_pdf = explode('storage/', $value->supplier_pdf);
		$supplierAttachment = $supplier_pdf[count($supplier_pdf) - 1];
		$encoded_supplierAttachment = str_replace(' ', '%20', $supplierAttachment);
		$body = new stdClass();
		$body->number = $vendorRegisNo;
		$body->webPortalEMail = "chiijian.chong@synic.com.my";
		$body->email = $value->email_address;
		$body->contact = $personName;
		$body->name = $value->name_of_company;
		$body->name2 = "name 2";
		$body->registeredAddress = $value->registered_address_one;
		$body->registeredAddress2 = $value->registered_address_two;
		$body->mailingAddress = $value->mailing_address_one;
		$body->mailingAddress2 = $value->mailing_address_two;
		$body->mailingCity = $value->city;
		$body->mailingState = $value->state;
		$body->mailingPostCode = $value->zip_code;
		$body->mailingCountry = $value->country;
		$body->phoneNo = $value->tel_no;
		$body->faxNo = $value->fax_no;
		$body->homePage = $value->company_website;
		$body->typeOfIncorporation = $value->type_of_company;
		$body->typeOfIncorporationOthers = $value->type_of_company_other;
		$body->dateIncorporated = $value->date_of_incorporation;
		$body->companyRegNo = $value->company_reg_no;
		$body->vatRegistrationNo = $value->sst_registration_no;
		$body->tin = "E000001";
		$body->idType = "";
		$body->idValue = "";
		$body->contactName1 = $value->contact_person_one;
		$body->designation1 = $value->designation_one;
		$body->contactName2 = $value->contact_person_two;
		$body->designation2 = $value->designation_two;
		$body->contactName3 = $value->contact_person_three;
		$body->designation3 = $value->designation_three;
		$body->annualTurnover = $value->annual_turnover;
		$body->workingCapital = $value->working_capital;
		$body->netWorth = $value->net_worth;
		$body->cashBankBalance = $value->cash_bank_balance;
		$body->paidUpCapital = $value->paid_up_capital;
		$body->productDescription1 = $value->product_desc_one;
		$body->productDescription2 = $value->product_desc_two;
		$body->productDescription3 = $value->product_desc_three;
		$body->productDescription4 = $value->product_desc_four;
		$body->productDescription5 = $value->product_desc_five;
		$body->productDescription6 = $value->product_desc_six;
		$body->creditTerms = $value->credit_term_offered;
		$body->creditTermsOthers = $value->credit_term_offered_other;
		$body->iSO9001 = $iso9001;
		$body->iSO14001 = $iso14001;
		$body->oHSAS18001 = $iso45001;
		$body->iSO37001 = $iso37001;
		$body->certificationOthers = $otherCertificate;
		$body->certificationPleaseSpecify = $value->certification_other;
		$body->litigationRecords = $value->litigation_records;
		$body->litigationRecordsDesc = $value->litigation_records_other;
		$body->corruptionFraudulent = $value->corruption_fraudulent_records;
		$body->corruptionFraudulentDesc = $value->corruption_fraudulent_records_other;
		$body->businessRegistrationForm = "";
		$body->borangP = "abc.pdf|File2.pdf";
		$body->form49 = "abc.pdf|File2.pdf";
		$body->ic = "abc.pdf|File2.pdf";
		$body->bankStatement = "abc.pdf|File2.pdf";
		$body->vlod = "abc.pdf|File2.pdf";
		$body->bankName = "Hong Leong Bank";
		$body->bankBranch = "Subang";
		$body->swiftCode = "888888";
		$body->bankAccountNo = "999999";
		$body->bankAddress = "Bank Address 1";
		$body->bankAddress2 = "Bank Address 2";
		return $body;
	}

	/**
	 * @param VendorRegisterRequest $supplier
	 * Stores vendor Register data in the NAV system tables
	 * @return XML
	 */
	public static function xmlData($supplier)
	{
		$value = $supplier;
		$soapdata = "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
		<Body>
		    <CreateMultiple xmlns='urn:microsoft-dynamics-schemas/page/vendorregistration'>
		        <VendorRegistration_List>\n";
		//foreach ($supplier as $value) {
		$cert = explode(',', $value->certification);
		$personName = $value->vendorInfo->person_name;
		$status = 'Registered';
		$vendorRegisNo = $value->vendorInfo->vendor_regis_no;
		$iso9001 = in_array('ISO 9001', $cert) ? 'Yes' : 'No';
		$iso14001 = in_array('ISO-14001', $cert) ? 'Yes' : 'No';
		$iso45001 = in_array('OHSAS 18001 / ISO 45001', $cert) ? 'Yes' : 'No';
		$iso37001 = in_array('ISO 37001', $cert) ? 'Yes' : 'No';
		$otherSpecify = in_array('other', $cert) ? 'Yes' : 'No';
		$otherCertificate = isset($value->certification_other) ? 'Yes' : 'No';
		$companyArr = explode(';', $value->company_profile_files);
		$company_profile_files = "";

		foreach ($companyArr as $comp) {
			$linkExplode = explode('storage/', $comp);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$company_profile_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$company_attachment = trim($company_profile_files, '|');
		$encoded_company_attachment = str_replace(' ', '%20', $company_attachment);

		$productArr = explode(';', $value->product_files);
		$product_files = "";

		foreach ($productArr as $prod) {
			$linkExplode = explode('storage/', $prod);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$product_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$product_attachment = trim($product_files, '|');
		$encoded_product_attachment = str_replace(' ', '%20', $product_attachment);

		$certificateArr = explode(';', $value->certification_files);
		$certification_files = "";

		foreach ($certificateArr as $cert) {
			$linkExplode = explode('storage/', $cert);
			if (strlen($linkExplode[count($linkExplode) - 1]))
				$certification_files .= $linkExplode[count($linkExplode) - 1] . '|';
		}
		$certificate_attachment = trim($certification_files, '|');
		$encoded_certificate_attachment = str_replace(' ', '%20', $certificate_attachment);
		$productCatalogue = explode('storage/', $value->product_catalogue);
		$prodcatAttachment = $productCatalogue[count($productCatalogue) - 1];
		$encoded_prodcatAttachment = str_replace(' ', '%20', $prodcatAttachment);

		$declaration_by_supplier = explode('storage/', $value->declaration_by_supplier);
		$declarationSupplierAttachment = $declaration_by_supplier[count($declaration_by_supplier) - 1];
		$encoded_declarationSupplierAttachment = str_replace(' ', '%20', $declarationSupplierAttachment);

		$supplier_pdf = explode('storage/', $value->supplier_pdf);
		$supplierAttachment = $supplier_pdf[count($supplier_pdf) - 1];
		$encoded_supplierAttachment = str_replace(' ', '%20', $supplierAttachment);

		
		$soapdata .= "<VendorRegistration>
							<No>$vendorRegisNo</No>
							<E_Mail>$value->email_address</E_Mail>
							<Contact>$personName</Contact>
							<Name>$value->name_of_company</Name>
							<Registered_Address>$value->registered_address_one</Registered_Address>
							<Registered_Address_2>$value->registered_address_two</Registered_Address_2> 
							<Mailing_Address>$value->mailing_address_one</Mailing_Address>
							<Mailing_Address_2>$value->mailing_address_two</Mailing_Address_2>
							<Mailing_City>$value->city</Mailing_City>
							<Mailing_County>$value->state</Mailing_County>
							<Mailing_Country_Region_Code>$value->country</Mailing_Country_Region_Code>
							<Mailing_Post_Code>$value->zip_code</Mailing_Post_Code>
							<Phone_No>$value->tel_no</Phone_No>
							<Fax_No>$value->fax_no</Fax_No>
							<Home_Page>$value->company_website</Home_Page>
							<Type_of_Incorporation>$value->type_of_company</Type_of_Incorporation>
							<Type_of_Incorporation_Others>$value->type_of_company_other</Type_of_Incorporation_Others>
							<Date_Incorporated>$value->date_of_incorporation</Date_Incorporated>
							<Company_Reg_No>$value->company_reg_no</Company_Reg_No>
							<SST_Registration_No>$value->sst_registration_no</SST_Registration_No>
							<Contact_Name_1>$value->contact_person_one</Contact_Name_1>
							<Designation_1>$value->designation_one</Designation_1>
							<Contact_Name_2>$value->contact_person_two</Contact_Name_2>
							<Designation_2>$value->designation_two</Designation_2>
							<Contact_Name_3>$value->contact_person_three</Contact_Name_3>
							<Designation_3>$value->designation_three</Designation_3>
							<Annual_Turnover>$value->annual_turnover</Annual_Turnover>
							<Working_Capital>$value->working_capital</Working_Capital>
							<Net_Worth>$value->net_worth</Net_Worth>
							<Cash_Bank_Balance>$value->cash_bank_balance</Cash_Bank_Balance>
							<Paid_Up_Capital>$value->paid_up_capital</Paid_Up_Capital>
							<Product_Description_1>$value->product_desc_one</Product_Description_1>
							<Product_Description_2>$value->product_desc_two</Product_Description_2>
							<Product_Description_3>$value->product_desc_three</Product_Description_3>
							<Product_Description_4>$value->product_desc_four</Product_Description_4>
							<Product_Description_5>$value->product_desc_five</Product_Description_5>
							<Product_Description_6>$value->product_desc_six</Product_Description_6>
							<Credit_Terms>$value->credit_term_offered</Credit_Terms>
							<Credit_Terms_Others>$value->credit_term_offered_other</Credit_Terms_Others>
							<ISO_9001>$iso9001</ISO_9001>
							<ISO_14001>$iso14001</ISO_14001>
							<OHSAS_18001_ISO_45001>$iso45001</OHSAS_18001_ISO_45001>
							<ISO_37001>$iso37001</ISO_37001>
							<Certification_Others>$otherCertificate</Certification_Others>
							<Certification_Please_Specify>$value->certification_other</Certification_Please_Specify>
							<Litigation_Records>$value->litigation_records</Litigation_Records>
							<Litigation_Records_Desc>$value->litigation_records_other</Litigation_Records_Desc>
							<Corruption_Fraudulent>$value->corruption_fraudulent_records</Corruption_Fraudulent>
							<Corruption_Fraudulent_Desc>$value->corruption_fraudulent_records_other</Corruption_Fraudulent_Desc>

							<Status>$status</Status>
							<Attachment_SectionA>$encoded_company_attachment</Attachment_SectionA>
							<Attachment_SectionC1>$encoded_prodcatAttachment</Attachment_SectionC1>
							<Attachment_SectionC2>$encoded_product_attachment</Attachment_SectionC2>
							<Attachment_SectionE>$encoded_certificate_attachment</Attachment_SectionE>
							<Attachment_VendorRegistration>$encoded_declarationSupplierAttachment</Attachment_VendorRegistration>
							<Attachment_VLOD>$encoded_supplierAttachment</Attachment_VLOD>
						</VendorRegistration>\n";
						//}
		$soapdata .= "</VendorRegistration_List>
				</CreateMultiple>
			</Body>
		</Envelope>";
		return $soapdata;
	}
}
