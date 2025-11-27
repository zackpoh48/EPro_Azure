<?php

namespace App\Services;
use stdClass;

class PurchaseInvoiceService
{
    /*
    |--------------------------------------------------------------------------
    | Purchase order Service
    |--------------------------------------------------------------------------
    |
    | This service is used to create purchase invoice
    |
    */

    public static function getPurchaseInvoiceList(string $vendor_no)
    {
        try {
            // For order list
            $url = "eProcurement_PI_List";
            $headers = [
                "Content-Type" => "text/xml",
                "SoapAction" =>
                    "urn:microsoft-dynamics-schemas/page/eprocurement_pi_list",
            ];

            $filters = [
                [
                    "field" => "Buy_from_Vendor_No",
                    "criteria" => $vendor_no,
                ],
            ];

            $body = SoapService::getSoapBody($filters, "eprocurement_pi_list");
            $response = SoapService::sendSoapRequest(
                "GET",
                $url,
                $headers,
                $body,
                false
            );

            if ($response->success == false) {
                throw new \Exception($response->message, $response->code);
            }

            return $response
                ->data->SoapBody->ReadMultiple_Result->ReadMultiple_Result;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseInvoiceDetails(string $invoice_no)
    {
        try {
            // For order list
            $url = "eProcurement_PI";
            $headers = [
                "Content-Type" => "text/xml",
                "SoapAction" =>
                    "urn:microsoft-dynamics-schemas/page/eprocurement_pi",
            ];

            $body =
                "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
            <Body>
                <Read xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_pi'>
                    <No>" .
                $invoice_no .
                "</No>
                </Read></Body></Envelope>";

            $response = SoapService::sendSoapRequest(
                "GET",
                $url,
                $headers,
                $body,
                false
            );

            if ($response->success == false) {
                throw new \Exception($response->message, $response->code);
            }

            $purchase_invoice_details =
                $response->data->SoapBody->Read_Result->eProcurement_PI;
            $purchase_invoice_lines = [];
            $purchase_invoice = new stdClass();
            $purchase_invoice->key = $purchase_invoice_details->Key;
            $purchase_invoice->no = $purchase_invoice_details->No;
            $purchase_invoice->document_date =
                $purchase_invoice_details->Document_Date;
            $purchase_invoice->amount_including_VAT =
                $purchase_invoice_details->Amount_Including_VAT;

            if (
                isset(
                    $purchase_invoice_details->eProcurement_PI_Line
                        ->eProcurement_PI_Line
                )
            ) {
                $lines =
                    $purchase_invoice_details->eProcurement_PI_Line
                        ->eProcurement_PI_Line;

                if (is_object($lines)) {
                    $lines = [$lines];
                }

                foreach ($lines as $line) {
                    $delivery_order_line = new stdClass();
                    $delivery_order_line->key = $line->Key ?? null;
                    $delivery_order_line->buy_from_vendor_no =
                        $line->Buy_from_Vendor_No ?? null;
                    $delivery_order_line->no = $line->No ?? null;
                    $delivery_order_line->description =
                        $line->Description ?? null;
                    $delivery_order_line->quantity = $line->Quantity ?? null;
                    $delivery_order_line->direct_unit_cost =
                        $line->Direct_Unit_Cost ?? null;
                    $delivery_order_line->line_amount =
                        $line->Line_Amount ?? null;
                    array_push($purchase_invoice_lines, $delivery_order_line);
                }
            }
            $purchase_invoice->purchase_invoice_lines = $purchase_invoice_lines;
            return $purchase_invoice;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
