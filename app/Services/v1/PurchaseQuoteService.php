<?php

namespace App\Services\v1;


class PurchaseQuoteService
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
     * Stores vendor Register data in the NAV system tables
     * @return XML
     */
    public static function xmlData($quotes, $items)
    {
        $vendor_no = $quotes->vendorNumber->vendor_regis_no;
        $type = 'Item';
        $documentDiscount = $quotes->document_discount ?? 0;

        $encoded_quotation_attachment="";
        if($quotes->quotation_files){
            $quotationArr = explode(';', $quotes->quotation_files);
            $quotation_files = "";
    
            foreach ($quotationArr as $quot) {
                $linkExplode = explode('storage/', $quot);
                if (strlen($linkExplode[count($linkExplode) - 1]))
                    $quotation_files .= $linkExplode[count($linkExplode) - 1] . '|';
            }
            $quotation_attachment = trim($quotation_files, '|');
            $encoded_quotation_attachment = str_replace(' ', '%20', $quotation_attachment);
        }

        $soapdata = "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
        <Body>
            <Create xmlns='urn:microsoft-dynamics-schemas/page/purchasequote'>
                <PurchaseQuote>\n";
        $soapdata .= "<Vendor_No>$vendor_no</Vendor_No>
                        <Document_Date>$quotes->date_of_rfq</Document_Date>
                        <Expected_Receipt_Date>$quotes->delivery_date</Expected_Receipt_Date>
                        <Payment_Terms_Code>$quotes->pay_terms</Payment_Terms_Code>
                        <Supplier_Remarks>$quotes->supplier_remarks</Supplier_Remarks>
                        <Location_Code>$quotes->delivery_code</Location_Code>
                        <Requisition_No>$quotes->quotation_no</Requisition_No>
                        <RFQ_No>$quotes->rfq_id</RFQ_No>
                        <Your_Reference>$quotes->vendor_quotation_no</Your_Reference>
                        <Document_Discount_Pcnt>$documentDiscount</Document_Discount_Pcnt>
                        <Currency_Code>$quotes->currency</Currency_Code>
                        <Attachments>$encoded_quotation_attachment</Attachments>
                        <!-- Optional -->
                        <PurchLines>";
        foreach ($items as $item) {

            $soapdata .= "<Purchase_Quote_Subform_API>
                            <Line_No>$item->s_no</Line_No>
                            <Type>$type</Type>
                            <No>$item->item_no</No>
                            <Description>$item->item_description</Description>
                            <Quantity>$item->offer_qty</Quantity>
                            <Unit_of_Measure_Code>$item->uom</Unit_of_Measure_Code>
                            <Offered_UOM>$item->offer_uom</Offered_UOM>
                            <Direct_Unit_Cost>$item->cost</Direct_Unit_Cost>
                            <Line_Discount_Percent>$item->discount</Line_Discount_Percent>
                            <Remarks_By_Vendor>$item->remarks</Remarks_By_Vendor>
                            <SST_Pcnt>$item->sst</SST_Pcnt>
                            <Document_Discount_Pcnt>$documentDiscount</Document_Discount_Pcnt>
                        </Purchase_Quote_Subform_API>";
        }

        $soapdata .= "</PurchLines>\n
                    </PurchaseQuote>
                    </Create>
                </Body>
            </Envelope>";
        return $soapdata;
    }

    public static function getPurchaseQuoteJSONData($rfqSubmission)
    {
        $purchaseQuoteLines = [];
        foreach ($rfqSubmission->items as $item) {
            $purchaseQuoteLines[] = [
                "@odata.etag"       => "",
                // "purchaseQuoteNo" => "",
                // "LineNo" => $item->s_no,
                "type" => 'Item',
                "no" => $item->item_no,
                "description" => $item->item_description,
                "quantity" => (float)$item->qty ?? 0,
                "unitOfMeasureCode" => $item->uom,
                "offeredQuantity" => (float)$item->offer_qty ?? 0,
                "offeredUOM" => $item->offer_uom ?? "",
                "directUnitCost" => (float)$item->cost ?? 0,
                "lineDiscountPcnt" => (float)$item->discount ?? 0,
                "sstPcnt" => (float)$item->sst ?? 0,
                "remarksByVendor" => $item->remarks,
                // "documentDiscountPcnt" =>$rfqSubmission->document_discount ?? 0,
            ];
        }

        $purchaseQuoteData = [
            "@odata.etag" => "", 
            //"rfq_id" => $rfqSubmission->rfq_id,
            //"date_of_rfq" => $rfqSubmission->date_of_rfq,
            //"priority" => $rfqSubmission->priority,
            //"date_of_expiry" => $rfqSubmission->date_of_expiry,
            //"quotation_no" => $rfqSubmission->quotation_no,
            //"buyer_remarks" => $rfqSubmission->buyer_remarks,
            //"tender_title" => $rfqSubmission->tender_title,
            //"status" => $rfqSubmission->status,

            "no" => "",
            "buyfromVendorNo" => $rfqSubmission->vendor_number ?? "",
            "expectedreceiptDate" => $rfqSubmission->expected_delivery ?? now()->toDateString(),
            "paymentTermsCode" => $rfqSubmission->pay_terms ?? "",
            "paymentMethodCode" => "",
            "requisitionNo" => $rfqSubmission->vendor_quotation_no,
            "rfqNo" => $rfqSubmission->rfq_id ?? "",
            "currencyCode" => $rfqSubmission->currency ?? "USD",
            "supplierRemarks" => $rfqSubmission->supplier_remarks ?? "",
            "documentDiscountPcnt" => $rfqSubmission->document_discount ?? 0,
            "fileAttachments" => $rfqSubmission->quotation_files ? str_replace('/storage', '', $rfqSubmission->quotation_files)  : "",
            "locationCode" => $rfqSubmission->delivery_code ?? "",
            "subPurchaseQuoteLines"   => $purchaseQuoteLines,
        ];

        return json_encode($purchaseQuoteData, JSON_PRETTY_PRINT);
    }
}
