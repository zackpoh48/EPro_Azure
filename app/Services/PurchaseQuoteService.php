<?php

namespace App\Services;

use App\Http\Requests\PurchaseQuoteRequest;
use App\Models\Company;
use App\Models\Organization;
use App\Models\PurchaseQuote;
use App\Models\PurchaseQuoteLine;
use App\Services\BusinessCentral\BusinessCentralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class PurchaseQuoteService
{
    /*
    |--------------------------------------------------------------------------
    | Delivery order Service
    |--------------------------------------------------------------------------
    |
    | This service is used to create delivery orders
    |
    */

    public static function store(
        PurchaseQuoteRequest $pqRequest,
        Company $company
    ) {
        try {
            \DB::beginTransaction();

            $pqEntity = PurchaseQuote::where("company_id", $company->id)
                ->where("is_complete", 0)
                ->where("user_id", $pqRequest->user()->id)
                ->firstOrNew();

            $pqEntity->purchase_quote_no =
                htmlspecialchars($pqRequest["purchase_quote_no"]) ?? null;

            $pqEntity->date =
                $pqRequest["date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(str_replace(",", " ", $pqRequest["date"]))
                )
                : null;

            $pqEntity->quotation_date =
                $pqRequest["quotation_date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(",", " ", $pqRequest["quotation_date"])
                    )
                )
                : null;

            $pqEntity->vendor_quote_no =
                htmlspecialchars($pqRequest["vendor_quote_no"]) ?? null;
            $pqEntity->is_complete = $pqRequest["is_complete"];
            $pqEntity->user_id = $pqRequest->user()->id;
            $pqEntity->company_id = $company->id;
            $pqEntity->organization_id = $company->organization_id;
            $pqEntity->vendor_no = $company->vendor_no;

            $pqEntity->amount_including_sst =
                $pqRequest["amount_including_sst"] ?? null;

            $pqEntity->currency =
                htmlspecialchars($pqRequest["currency"]) ?? null;

            $pqEntity->reference =
                htmlspecialchars($pqRequest["reference"]) ?? null;

            $pqEntity->last_line_no = (int) $pqRequest["last_line_no"] ?? null;

            $name = $pqRequest->user()->unique_id;
            if ($pqRequest->hasfile("support_attachments")) {
                $support_attachments = "";
                foreach ($pqRequest->file("support_attachments") as $file) {
                    $supportAttach =
                        $file->storeAs(
                            "public/" . $name,
                            $file->getClientOriginalName()
                        ) . ";";
                    $supportDoc = Storage::disk("local")->url($supportAttach);
                    $support_attachments .= $supportDoc;
                }
                $pqEntity->support_attachments = $support_attachments;
            }

            $pqEntity->save();
            $pqEntity->purchaseQuoteLines()->delete();

            $pqLineEntities = [];
            if (isset($pqRequest["purchase_quote_lines"])) {
                foreach ($pqRequest["purchase_quote_lines"]
                    as $purchaseQuoteLine) {
                    $doLineEntity = new PurchaseQuoteLine();

                    if (isset($purchaseQuoteLine["line_no"])) {
                        $doLineEntity->line_no = htmlspecialchars(
                            $purchaseQuoteLine["line_no"]
                        );
                    }

                    if (isset($purchaseQuoteLine["type"])) {
                        $doLineEntity->type = htmlspecialchars(
                            $purchaseQuoteLine["type"]
                        );
                    }

                    if (isset($purchaseQuoteLine["description"])) {
                        $doLineEntity->description = htmlspecialchars(
                            $purchaseQuoteLine["description"]
                        );
                    }

                    if (isset($purchaseQuoteLine["quantity"])) {
                        $doLineEntity->quantity = htmlspecialchars(
                            $purchaseQuoteLine["quantity"]
                        );
                    }

                    if (isset($purchaseQuoteLine["unit_of_measure_code"])) {
                        $doLineEntity->unit_of_measure_code = htmlspecialchars(
                            $purchaseQuoteLine["unit_of_measure_code"]
                        );
                    }
                    if (isset($purchaseQuoteLine["direct_unit_cost"])) {
                        $doLineEntity->direct_unit_cost = htmlspecialchars(
                            $purchaseQuoteLine["direct_unit_cost"]
                        );
                    }
                    if (isset($purchaseQuoteLine["line_amount"])) {
                        $doLineEntity->line_amount = htmlspecialchars(
                            $purchaseQuoteLine["line_amount"]
                        );
                    }

                    $doLineEntity->purchase_quote_no =
                        htmlspecialchars($pqRequest["purchase_quote_no"]) ??
                        null;

                    array_push($pqLineEntities, $doLineEntity);
                }
                $pqEntity->purchaseQuoteLines()->saveMany($pqLineEntities);
            }

            \DB::commit();
            $pqEntity->purchase_quote_lines = $pqLineEntities;
            return $pqEntity;
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function show(Request $request, Company $company)
    {
        try {
            $draftPurchaseQuote = PurchaseQuote::with("purchaseQuoteLines")
                ->where([
                    ["company_id", $company->id],
                    ["is_complete", 0],
                    ["user_id", $request->user()->id],
                ])
                ->first();

            $quote = new \stdClass();
            if ($draftPurchaseQuote) {
                $draftPurchaseQuote = (object) $draftPurchaseQuote->toArray();
                $quote->no = $draftPurchaseQuote->purchase_quote_no;
                $quote->order_date = $draftPurchaseQuote->date;
                $quote->buy_from_vendor_no =
                    $draftPurchaseQuote->vendor_quote_no;
                $quote->document_date = $draftPurchaseQuote->quotation_date;
                $quote->currency_code = $draftPurchaseQuote->currency;
                $quote->amount_including_vat =
                    $draftPurchaseQuote->amount_including_sst;
                $quote->reference = $draftPurchaseQuote->reference;
                $quote->support_attachments =
                    $draftPurchaseQuote->support_attachments;
                $quote->last_line_no = $draftPurchaseQuote->last_line_no;
                $quote->purchase_quote_lines =
                    $draftPurchaseQuote->purchase_quote_lines;
            } else {
                $quote->no = "";
                $quote->amount_including_vat = 0;
                $quote->purchase_quote_lines = [];
                $quote->order_date = now();
                $quote->buy_from_vendor_no = "";
                $quote->document_date = "";
                $quote->currency_code = "MYR";
                $quote->reference = "";
                $quote->support_attachments = "";
                $quote->last_line_no = "";
            }

            return $quote;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function delete(Request $request, Company $company)
    {
        try {
            $purchaseQuote = PurchaseQuote::with("purchaseQuoteLines")
                ->where([
                    ["company_id", $company->id],
                    ["is_complete", 0],
                    ["user_id", $request->user()->id],
                ])
                ->first();

            if ($purchaseQuote) {
                $purchaseQuote->delete();
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseQuoteDetails(
        string $order_number,
        Organization $organization
    ) {
        try {
            // $url = "eProcurement_PQ";
            // $headers = [
            //     "Content-Type" => "text/xml",
            //     "SoapAction" =>
            //         "urn:microsoft-dynamics-schemas/page/eprocurement_pq",
            // ];

            // $body =
            //     "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
            //     <Body><Read xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_pq'>
            //             <No>" .
            //     $order_number .
            //     "</No></Read></Body></Envelope>";

            // $response = SoapService::sendSoapRequest(
            //     "GET",
            //     $url,
            //     $organization,
            //     false,
            //     $headers,
            //     $body
            // );

            $businessCentralService = new BusinessCentralService();

            $response = $businessCentralService->getQuote($organization->unique_id, $order_number);

            if (!$response) {
                throw new \Exception($response->message, $response->code);
            }

            $purchase_quote_details =
                $response;
            $purchase_quote_lines = [];
            $purchase_quote = new stdClass();
            $purchase_quote->key = $purchase_quote_details->Key ?? null;
            $purchase_quote->no = $purchase_quote_details->No ?? null;
            $purchase_quote->buy_from_vendor_no =
                $purchase_quote_details->Buy_from_Vendor_No ?? null;
            $purchase_quote->vendor_order_no =
                $purchase_quote_details->Vendor_Order_No ?? null;
            $purchase_quote->order_date =
                $purchase_quote_details->Order_Date ?? null;
            $purchase_quote->document_date =
                $purchase_quote_details->Document_Date ?? null;
            // $purchase_quote->expected_receipt_date =
            //     $purchase_quote_details->Expected_Receipt_Date ?? null;
            $purchase_quote->amount_including_vat =
                $purchase_quote_details->Amount_Including_VAT ?? null;
            $purchase_quote->currency_code =
                $purchase_quote_details->Currency_Code ?? null;
            // $purchase_quote->last_payment_date =
            //     $purchase_quote_details->Last_Payment_Date ?? null;
            // $purchase_quote->outstandingAmount =
            //     $purchase_quote_details->OutstandingAmount ?? null;

            if (
                isset(
                    $purchase_quote_details->eProcurement_PQ_Line
                        ->eProcurement_PQ_Line
                )
            ) {
                $lines =
                    $purchase_quote_details->eProcurement_PQ_Line
                    ->eProcurement_PQ_Line;

                if (is_object($lines)) {
                    $lines = [$lines];
                }

                foreach ($lines as $line) {
                    $purchase_quote_line = new stdClass();
                    // $purchase_quote_line->no = $line->No ?? null;
                    $purchase_quote_line->line_no = $line->Line_No ?? null;
                    $purchase_quote_line->type = $line->Type ?? null;
                    $purchase_quote_line->description =
                        $line->Description ?? null;
                    // $purchase_quote_line->location_code =
                    //     $line->Location_Code ?? null;
                    $purchase_quote_line->quantity = $line->Quantity ?? null;
                    $purchase_quote_line->unit_of_measure_code =
                        $line->Unit_of_Measure_Code ?? null;
                    $purchase_quote_line->direct_unit_cost =
                        $line->Direct_Unit_Cost ?? null;
                    $purchase_quote_line->line_amount =
                        $line->Line_Amount ?? null;
                    array_push($purchase_quote_lines, $purchase_quote_line);
                }
            }
            $purchase_quote->purchase_quote_lines = $purchase_quote_lines;
            return $purchase_quote;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseQuoteListVendor(string $vendor_no, Organization $organization, string $status) {
        try {
            $businessCentralService = new BusinessCentralService();
            $response = $businessCentralService->getPurchaseQuoteList($organization->unique_id, $vendor_no, "Released");

            return $response;
        }
        catch(\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseQuoteList(
        string $vendor_no,
        Organization $organization
    ) {
        try {
            // $url = "eProcurement_PQ_List";
            // $headers = [
            //     "Content-Type" => "text/xml",
            //     "SoapAction" =>
            //     "urn:microsoft-dynamics-schemas/page/eprocurement_pq_list",
            // ];

            // $filters = [
            //     [
            //         "field" => "Buy_from_Vendor_No",
            //         "criteria" => $vendor_no,
            //     ],
            // ];

            // $body = SoapService::getSoapBody($filters, "eprocurement_pq_list");
            // $response = SoapService::sendSoapRequest(
            //     "GET",
            //     $url,
            //     $organization,
            //     false,
            //     $headers,
            //     $body
            // );

            // if ($response->success == false) {
            //     throw new \Exception($response->message, $response->code);
            // }

            $businessCentralService = new BusinessCentralService();

            $response = $businessCentralService->getListQuotes($organization->unique_id, $vendor_no);

            return $response;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
