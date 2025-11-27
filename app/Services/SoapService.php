<?php

namespace App\Services;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\PurchaseQuote;
use App\Models\UpdatedVendorProfile;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use stdClass;

class SoapService
{
    /*
    |--------------------------------------------------------------------------
    | Soap Service
    |--------------------------------------------------------------------------
    |
    | This service is used to create soap body and handle soap requests
    |
    */

    public static function getSoapBody($filters, $soapAction)
    {
        $soapBody =
            "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
        <Body>
            <ReadMultiple xmlns='urn:microsoft-dynamics-schemas/page/" .
            $soapAction .
            "'><filter>";

        foreach ($filters as $filter) {
            $soapBody .=
                "<Field>" .
                $filter["field"] .
                "</Field>
                <Criteria>" .
                $filter["criteria"] .
                "</Criteria>";
        }

        $soapBody .= "</filter>
        <bookmarkKey></bookmarkKey>
        <setSize></setSize>
            </ReadMultiple>
        </Body>
        </Envelope>";
        return $soapBody;
    }

    public static function convertSoapData($soapData, $convertToArray = false)
    {
        $xml = $soapData;
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $xml);
        $xml = simplexml_load_string($xml);
        if (false === $xml) {
            // Put breakpoint here
            $errors = libxml_get_errors();
            throw new \Exception($errors, 500);
        }
        $json = json_encode($xml);
        $response = json_decode($json, $convertToArray); // true to have an array, false for an object
        return $response;
    }

    public static function sendSoapRequest(
        $method,
        $uri,
        $organization,
        $throwError,
        $headers = [],
        $body = "",
        $getXmlResponse = false
    ) {
        try {
            $url =
                $organization->nav_server .
                ":" .
                $organization->nav_port .
                "/" .
                $organization->nav_environment .
                "/WS/" .
                $organization->nav_company .
                "/Page/" .
                $uri;

            if ($organization->nav_auth) {
                $client = new Client([
                    "auth" => [
                        $organization->nav_username,
                        $organization->nav_password,
                        $organization->nav_auth,
                    ],
                ]);
            } else {
                $client = new Client([
                    "auth" => [
                        $organization->nav_username,
                        $organization->nav_password,
                    ],
                ]);
            }

            $response = new stdClass();
            $options = $throwError === true ? [] : ["http_errors" => false];
            $request = new Request($method, $url, $headers, $body);
            $navResponse = $client->send($request, $options);
            if ($getXmlResponse === true) {
                $response->data = $navResponse->getBody()->getContents();
                $response->headers = $headers;
                $response->url = $url;
            } else {
                $responseBody = SoapService::convertSoapData(
                    $navResponse->getBody()->getContents()
                );

                $response = new stdClass();
                $response->code = $navResponse->getStatusCode();
                $response->data = null;
                $response->message = null;
                $response->success = true;

                if ($response->code != 200) {
                    $response->success = false;
                    $response->message =
                        $response->code == 500 &&
                        isset($responseBody->sBody->sFault->faultstring)
                            ? $responseBody->sBody->sFault->faultstring
                            : $responseBody;
                } else {
                    $response->data = $responseBody;
                }
            }

            return $response;
        } catch (\Exception $e) {
            if ($getXmlResponse === true) {
                return $navResponse;
            }
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Company $company
     * Stores user Register data in the NAV system tables
     */
    public static function getRegistrationXmlData(Company $company)
    {
        $user = json_decode($company->created_by);
        // $timeStamp = new \DateTime($company->completed_at);
        // $timeStamp = $timeStamp->format("Y-m-d\TH:i:s\Z");
        $status = "Registered";
        $registrationArr = explode(
            ";",
            $company->latest_business_registration_files
        );
        $latest_business_registration_files = "";
        foreach ($registrationArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $latest_business_registration_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $business_registration_attachment = trim(
            $latest_business_registration_files,
            "|"
        );
        $encoded_business_registration_attachment = str_replace(
            " ",
            "%20",
            $business_registration_attachment
        );

        $borangArr = explode(";", $company->borang_p_files);
        $borang_p_files = "";
        foreach ($borangArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $borang_p_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $borang_p_attachment = trim($borang_p_files, "|");
        $encoded_borang_p_attachment = str_replace(
            " ",
            "%20",
            $borang_p_attachment
        );

        $formArr = explode(";", $company->form_49_files);
        $form_49_files = "";
        foreach ($formArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $form_49_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $form_49_attachment = trim($form_49_files, "|");
        $encoded_form_49_attachment = str_replace(
            " ",
            "%20",
            $form_49_attachment
        );

        $photocopyArr = explode(";", $company->photocopy_ic_files);
        $photocopy_ic_files = "";
        foreach ($photocopyArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $photocopy_ic_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $photocopy_ic_attachment = trim($photocopy_ic_files, "|");
        $encoded_photocopy_ic_attachment = str_replace(
            " ",
            "%20",
            $photocopy_ic_attachment
        );

        $statementArr = explode(";", $company->bank_statement_attachments);
        $bank_statement_attachments = "";
        foreach ($statementArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $bank_statement_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $bank_statement_attachment = trim($bank_statement_attachments, "|");
        $encoded_bank_statement_attachment = str_replace(
            " ",
            "%20",
            $bank_statement_attachment
        );

        // $supplier_pdf = explode("storage/", $user->supplier_pdf);
        // $supplierAttachment = $supplier_pdf[count($supplier_pdf) - 1];
        // $encoded_supplierAttachment = str_replace(
        //     " ",
        //     "%20",
        //     $supplierAttachment
        // );

        $soapdata = "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
        <Body><Create xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_vendor_registration'>
                        <eProcurement_Vendor_Registration>
                            <No>$company->vendor_no</No>
                            <Web_Portal_E_Mail>$user->email</Web_Portal_E_Mail>
							<E_Mail>$user->registered_email_address</E_Mail>
							<Contact>$user->name</Contact>
							<Name>$company->company_name</Name>
                            <Name_2></Name_2>
							<Registered_Address>$company->registered_address_one</Registered_Address>
							<Registered_Address_2>$company->registered_address_two</Registered_Address_2>
							<Mailing_Address>$company->mailing_address_one</Mailing_Address>
							<Mailing_Address_2>$company->mailing_address_two</Mailing_Address_2>
							<Mailing_City>$company->city</Mailing_City>
							<Mailing_County>$company->state</Mailing_County>
							<Mailing_Post_Code>$company->zip_code</Mailing_Post_Code>
                            <Mailing_Country>$company->country</Mailing_Country>
							<Phone_No>$company->tel_no</Phone_No>
							<Fax_No>$company->fax_no</Fax_No>
							<Home_Page>$company->company_website</Home_Page>
							<Type_of_Incorporation>$company->type_of_company</Type_of_Incorporation>
							<Type_of_Incorporation_Others>$company->type_of_company_other</Type_of_Incorporation_Others>
							<Date_Incorporated>$company->date_of_incorporation</Date_Incorporated>
							<Company_Reg_No>$company->company_reg_no</Company_Reg_No>
							<SST_Registration_No>$company->sst_registration_no</SST_Registration_No>
							<Contact_Name_1>$company->contact_person_one</Contact_Name_1>
							<Designation_1>$company->designation_one</Designation_1>
							<Contact_Name_2>$company->contact_person_two</Contact_Name_2>
							<Designation_2>$company->designation_two</Designation_2>
							<Contact_Name_3>$company->contact_person_three</Contact_Name_3>
							<Designation_3>$company->designation_three</Designation_3>
							<Status>$status</Status>
							<Credit_Terms>$company->credit_term_offered</Credit_Terms>
							<Credit_Terms_Others>$company->credit_term_offered_other</Credit_Terms_Others>
							<Attachment_SectionA>$encoded_business_registration_attachment</Attachment_SectionA>
							<Attachment_SectionC1>$encoded_borang_p_attachment</Attachment_SectionC1>
							<Attachment_SectionC2>$encoded_form_49_attachment</Attachment_SectionC2>
							<Attachment_SectionE>$encoded_photocopy_ic_attachment</Attachment_SectionE>
							<Attachment_VendorRegistration>$encoded_bank_statement_attachment</Attachment_VendorRegistration>
                            <Bank_Name>$company->bank_name</Bank_Name>
                            <Bank_Branch>$company->bank_branch</Bank_Branch>
                            <SWIFT_Code>$company->swift_code</SWIFT_Code>
                            <Bank_Account_No>$company->bank_account_no</Bank_Account_No>
                            <Bank_Address>$company->bank_address_one</Bank_Address>
                            <Bank_Address_2>$company->bank_address_two</Bank_Address_2>
						 </eProcurement_Vendor_Registration>
                         </Create>
               </Body>
             </Envelope>";

        return $soapdata;
    }

    /**
     * @param DeliveryOrder $deliveryOrder
     * Stores Delivery order data in the NAV system tables
     */
    public static function getDeliveryOrderXmlData(DeliveryOrder $deliveryOrder)
    {
        $deliveryArr = explode(";", $deliveryOrder->delivery_attachments);
        $delivery_attachments = "";
        foreach ($deliveryArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $delivery_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $delivery_attachment_files = trim($delivery_attachments, "|");
        $encoded_delivery_attachment_files = str_replace(
            " ",
            "%20",
            $delivery_attachment_files
        );

        $invoiceArr = explode(";", $deliveryOrder->invoice_attachments);
        $invoice_attachments = "";
        foreach ($invoiceArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $invoice_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $invoice_attachment_files = trim($invoice_attachments, "|");
        $encoded_invoice_attachment_files = str_replace(
            " ",
            "%20",
            $invoice_attachment_files
        );

        $deliveryOrderLines = $deliveryOrder->deliveryOrderLines()->get();
        $deliveryOrderLinesNav = "";

        foreach ($deliveryOrderLines as $deliveryOrderLine) {
            if (
                (isset($deliveryOrderLine->quantity_to_deliver) &&
                    $deliveryOrderLine->quantity_to_deliver >= 0) ||
                (isset($deliveryOrderLine->amount_to_deliver_including_sst) &&
                    $deliveryOrderLine->amount_to_deliver_including_sst > 0)
            ) {
                $quantity_to_deliver =
                    $deliveryOrderLine->quantity_to_deliver ?? 0;
                $deliveryOrderLinesNav .= "<eProcurement_Submit_DO_Line>
                        <Line_No>$deliveryOrderLine->line_no</Line_No>
                        <Type>$deliveryOrderLine->type</Type>
                        <No>$deliveryOrderLine->no</No>
                        <Description>$deliveryOrderLine->description</Description>
                        <Location_Code>$deliveryOrderLine->location_code</Location_Code>
                        <Quantity>$deliveryOrderLine->quantity</Quantity>
                        <Direct_Unit_Cost>$deliveryOrderLine->unit_cost_including_sst</Direct_Unit_Cost>
                        <Line_Amount>$deliveryOrderLine->amount_including_sst</Line_Amount>
                        <Quantity_Received>$deliveryOrderLine->quantity_delivered</Quantity_Received>
                        <Quantity_Invoiced>$deliveryOrderLine->quantity_invoiced</Quantity_Invoiced>
                        <Quantity_To_Deliver>$quantity_to_deliver</Quantity_To_Deliver>
                        <Outstanding_Quantity>$deliveryOrderLine->outstanding_quantity</Outstanding_Quantity>
                        <Deliver_With_Amount>$deliveryOrderLine->deliver_with_amount</Deliver_With_Amount>
                        <Amount_to_Deliver_Incl_SST>$deliveryOrderLine->amount_to_deliver_including_sst</Amount_to_Deliver_Incl_SST>
                        <Amount_Delivered>$deliveryOrderLine->amount_delivered</Amount_Delivered>
                        <Outstanding_Amount>$deliveryOrderLine->outstanding_amount</Outstanding_Amount>
                    </eProcurement_Submit_DO_Line>";
            }
        }

        $soapdata = "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
        <Body>
            <Create xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_submitdo'>
                <eProcurement_SubmitDO>
                    <No>$deliveryOrder->purchase_order_no</No>
                    <Order_Date>$deliveryOrder->order_date</Order_Date>
                    <Expected_Receipt_Date>$deliveryOrder->expected_receipt_date</Expected_Receipt_Date>
                    <Currency_Code>$deliveryOrder->currency_code</Currency_Code>
                    <Amount_Including_VAT>$deliveryOrder->amount_including_vat</Amount_Including_VAT>
                    <Delivery_Order_No>$deliveryOrder->delivery_order_no</Delivery_Order_No>
                    <Delivery_Order_Date>$deliveryOrder->delivery_order_date</Delivery_Order_Date>
                    <AttachmentDelivery>$encoded_delivery_attachment_files</AttachmentDelivery>
                    <Invoice_No>$deliveryOrder->invoice_no</Invoice_No>
                    <Invoice_Date>$deliveryOrder->invoice_date</Invoice_Date>
                    <AttachmentInvoice>$encoded_invoice_attachment_files</AttachmentInvoice>
                    <eProcurement_Submit_DO_Line>$deliveryOrderLinesNav</eProcurement_Submit_DO_Line>       
                    </eProcurement_SubmitDO>
                    </Create>
                </Body>
            </Envelope>";

        return $soapdata;
    }

    /**
     * @param UpdatedVendorProfile $vendor
     * Stores user Register data in the NAV system tables
     */
    public static function getVendorProfileXmlData(UpdatedVendorProfile $vendor)
    {
        // $status = "Registered";
        $registrationArr = explode(
            ";",
            $vendor->latest_business_registration_files
        );
        $latest_business_registration_files = "";
        foreach ($registrationArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $latest_business_registration_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $business_registration_attachment = trim(
            $latest_business_registration_files,
            "|"
        );
        $encoded_business_registration_attachment = str_replace(
            " ",
            "%20",
            $business_registration_attachment
        );

        $borangArr = explode(";", $vendor->borang_p_files);
        $borang_p_files = "";
        foreach ($borangArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $borang_p_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $borang_p_attachment = trim($borang_p_files, "|");
        $encoded_borang_p_attachment = str_replace(
            " ",
            "%20",
            $borang_p_attachment
        );

        $formArr = explode(";", $vendor->form_49_files);
        $form_49_files = "";
        foreach ($formArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $form_49_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $form_49_attachment = trim($form_49_files, "|");
        $encoded_form_49_attachment = str_replace(
            " ",
            "%20",
            $form_49_attachment
        );

        $photocopyArr = explode(";", $vendor->photocopy_ic_files);
        $photocopy_ic_files = "";
        foreach ($photocopyArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $photocopy_ic_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $photocopy_ic_attachment = trim($photocopy_ic_files, "|");
        $encoded_photocopy_ic_attachment = str_replace(
            " ",
            "%20",
            $photocopy_ic_attachment
        );

        $statementArr = explode(";", $vendor->bank_statement_attachments);
        $bank_statement_attachments = "";
        foreach ($statementArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $bank_statement_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $bank_statement_attachment = trim($bank_statement_attachments, "|");
        $encoded_bank_statement_attachment = str_replace(
            " ",
            "%20",
            $bank_statement_attachment
        );

        $soapdata = "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
        <Body><Create xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_vendor_profile'>
                        <eProcurement_Vendor_Profile>
                            <Key>No</Key>
                            <No>$vendor->vendor_no</No>
                            <Web_Portal_E_Mail>$vendor->email</Web_Portal_E_Mail>
							<E_Mail>$vendor->registered_email_address</E_Mail>
							<Contact>$vendor->name</Contact>
							<Name>$vendor->company_name</Name>
                            <Name_2></Name_2>
							<Registered_Address>$vendor->registered_address_one</Registered_Address>
							<Registered_Address_2>$vendor->registered_address_two</Registered_Address_2>
							<Mailing_Address>$vendor->mailing_address_one</Mailing_Address>
							<Mailing_Address_2>$vendor->mailing_address_two</Mailing_Address_2>
							<Mailing_City>$vendor->city</Mailing_City>
							<Mailing_County>$vendor->state</Mailing_County>
							<Mailing_Post_Code>$vendor->zip_code</Mailing_Post_Code>
                            <Mailing_Country>$vendor->country</Mailing_Country>
							<Phone_No>$vendor->tel_no</Phone_No>
							<Fax_No>$vendor->fax_no</Fax_No>
							<Home_Page>$vendor->company_website</Home_Page>
							<Type_of_Incorporation>$vendor->type_of_company</Type_of_Incorporation>
							<Type_of_Incorporation_Others>$vendor->type_of_company_other</Type_of_Incorporation_Others>
							<Date_Incorporated>$vendor->date_of_incorporation</Date_Incorporated>
							<Company_Reg_No>$vendor->company_reg_no</Company_Reg_No>
							<SST_Registration_No>$vendor->sst_registration_no</SST_Registration_No>
							<Contact_Name_1>$vendor->contact_person_one</Contact_Name_1>
							<Designation_1>$vendor->designation_one</Designation_1>
							<Contact_Name_2>$vendor->contact_person_two</Contact_Name_2>
							<Designation_2>$vendor->designation_two</Designation_2>
							<Contact_Name_3>$vendor->contact_person_three</Contact_Name_3>
							<Designation_3>$vendor->designation_three</Designation_3>
							<Credit_Terms>$vendor->credit_term_offered</Credit_Terms>
							<Credit_Terms_Others>$vendor->credit_term_offered_other</Credit_Terms_Others>
							<Attachment_SectionA>$encoded_business_registration_attachment</Attachment_SectionA>
							<Attachment_SectionC1>$encoded_borang_p_attachment</Attachment_SectionC1>
							<Attachment_SectionC2>$encoded_form_49_attachment</Attachment_SectionC2>
							<Attachment_SectionE>$encoded_photocopy_ic_attachment</Attachment_SectionE>
							<Attachment_VendorRegistration>$encoded_bank_statement_attachment</Attachment_VendorRegistration>
                            <Bank_Name>$vendor->bank_name</Bank_Name>
                            <Bank_Branch>$vendor->bank_branch</Bank_Branch>
                            <SWIFT_Code>$vendor->swift_code</SWIFT_Code>
                            <Bank_Account_No>$vendor->bank_account_no</Bank_Account_No>
                            <Bank_Address>$vendor->bank_address_one</Bank_Address>
                            <Bank_Address_2>$vendor->bank_address_two</Bank_Address_2>
						 </eProcurement_Vendor_Profile>
                         </Create>
               </Body>
             </Envelope>";

        return $soapdata;
    }

    /**
     * @param PurchaseQuote $purchaseQuote
     * Stores user Register data in the NAV system tables
     */
    public static function getPurchaseQuoteXmlData(PurchaseQuote $purchaseQuote)
    {
        $soapdata = "<Soap:Envelope xmlns:Soap='http://schemas.xmlsoap.org/soap/envelope/'>
        <Soap:Body>
            <Create xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_submitpq'>
                <eProcurement_SubmitPQ>
                    <No>PORTAL006</No>
                    <Buy_from_Vendor_No>VR0000032</Buy_from_Vendor_No>
                    <Vendor_Order_No>TEST001</Vendor_Order_No>
                    <Order_Date>2023-07-05</Order_Date>
                    <Document_Date>2023-07-05</Document_Date>
                    <Currency_Code>MYR</Currency_Code>
                    <Your_Reference>TESTING</Your_Reference>
                    <Last_Line_No>20000</Last_Line_No>
                    <eProcurement_Submit_PQ_Line>
                    </eProcurement_Submit_PQ_Line>
                </eProcurement_SubmitPQ>
            </Create>
        </Soap:Body>
    </Soap:Envelope>";

        $supportArr = explode(";", $purchaseQuote->support_attachments);
        $support_attachments = "";
        foreach ($supportArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $support_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $support_attachment_files = trim($support_attachments, "|");
        $encoded_support_attachment_files = str_replace(
            " ",
            "%20",
            $support_attachment_files
        );

        $purchaseQuoteLines = $purchaseQuote->purchaseQuoteLines()->get();
        $purchaseQuoteLinesNav = "";

        foreach ($purchaseQuoteLines as $purchaseQuoteLine) {
            $purchaseQuoteLinesNav .= "<eProcurement_Submit_PQ_Line>
                        <Line_No>$purchaseQuoteLine->line_no</Line_No>
                        <Description>$purchaseQuoteLine->description</Description>
                        <Quantity>$purchaseQuoteLine->quantity</Quantity>
                        <Unit_of_Measure_Code>$purchaseQuoteLine->unit_of_measure_code</Unit_of_Measure_Code>
                        <Direct_Unit_Cost>$purchaseQuoteLine->direct_unit_cost</Direct_Unit_Cost>
                        <Line_Amount>$purchaseQuoteLine->line_amount</Line_Amount>
                    </eProcurement_Submit_PQ_Line>";
        }

        $soapdata = "<Soap:Envelope xmlns:Soap='http://schemas.xmlsoap.org/soap/envelope/'>
        <Soap:Body>
            <Create xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_submitpq'>
                <eProcurement_SubmitPQ>
                <No>$purchaseQuote->purchase_quote_no</No>
                <Buy_from_Vendor_No>$purchaseQuote->vendor_no</Buy_from_Vendor_No>
                <Vendor_Order_No>$purchaseQuote->vendor_quote_no</Vendor_Order_No>
                <Order_Date>$purchaseQuote->date</Order_Date>
                <Document_Date>$purchaseQuote->quotation_date</Document_Date>
                <Currency_Code>$purchaseQuote->currency</Currency_Code>
                <Your_Reference>$purchaseQuote->reference</Your_Reference>
                <Last_Line_No>$purchaseQuote->last_line_no</Last_Line_No>
                <AttachmentSupport>$encoded_support_attachment_files</AttachmentSupport>
                <eProcurement_Submit_PQ_Line>$purchaseQuoteLinesNav</eProcurement_Submit_PQ_Line>
                </eProcurement_SubmitPQ>
                </Create>
                </Soap:Body>
                </Soap:Envelope>";

        return $soapdata;
    }
}
