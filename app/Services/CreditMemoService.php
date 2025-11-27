<?php

namespace App\Services;
use stdClass;

class CreditMemoService
{
    /*
    |--------------------------------------------------------------------------
    | Credit memo Service
    |--------------------------------------------------------------------------
    |
    | This service is used to create credit memo
    |
    */

    public static function getCreditMemoList(string $vendor_no)
    {
        try {
            // For order list
            $url = "eProcurement_PCM_List";
            $headers = [
                "Content-Type" => "text/xml",
                "SoapAction" =>
                    "urn:microsoft-dynamics-schemas/page/eprocurement_pcm_list",
            ];

            $filters = [
                [
                    "field" => "Buy_from_Vendor_No",
                    "criteria" => $vendor_no,
                ],
            ];

            $body = SoapService::getSoapBody($filters, "eprocurement_pcm_list");
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

    public static function getCreditMemoDetails(string $credit_memo_no)
    {
        try {
            // For order list
            $url = "eProcurement_PCM";
            $headers = [
                "Content-Type" => "text/xml",
                "SoapAction" =>
                    "urn:microsoft-dynamics-schemas/page/eprocurement_pcm",
            ];

            $filters = [
                [
                    "field" => "Vendor_Cr_Memo_No",
                    "criteria" => $credit_memo_no,
                ],
            ];

            $body = SoapService::getSoapBody($filters, "eprocurement_pcm");

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

            $credit_memo_details =
                $response->data->SoapBody->ReadMultiple_Result
                    ->ReadMultiple_Result->eProcurement_PCM;
            $credit_memo_lines = [];
            $credit_memo = new stdClass();
            $credit_memo->key = $credit_memo_details->Key;
            $credit_memo->vendor_cr_memo_no =
                $credit_memo_details->Vendor_Cr_Memo_No;
            $credit_memo->document_date = $credit_memo_details->Document_Date;
            $credit_memo->currency_code = $credit_memo_details->Currency_Code;
            $credit_memo->amount_including_VAT =
                $credit_memo_details->Amount_Including_VAT;

            if (
                isset(
                    $credit_memo_details->eProcurement_PCM_Line
                        ->eProcurement_PCM_Line
                )
            ) {
                $lines =
                    $credit_memo_details->eProcurement_PCM_Line
                        ->eProcurement_PCM_Line;

                if (is_object($lines)) {
                    $lines = [$lines];
                }

                foreach ($lines as $line) {
                    $credit_memo_line = new stdClass();
                    $credit_memo_line->key = $line->Key ?? null;
                    $credit_memo_line->no = $line->No ?? null;
                    $credit_memo_line->description = $line->Description ?? null;
                    $credit_memo_line->loc_name = $line->LocName ?? null;
                    $credit_memo_line->quantity = $line->Quantity ?? null;
                    $credit_memo_line->unit_of_measure =
                        $line->Unit_of_Measure ?? null;
                    $credit_memo_line->direct_unit_cost =
                        $line->Direct_Unit_Cost ?? null;
                    $credit_memo_line->line_amount = $line->Line_Amount ?? null;
                    array_push($credit_memo_lines, $credit_memo_line);
                }
            }
            $credit_memo->credit_memo_lines = $credit_memo_lines;
            return $credit_memo;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
