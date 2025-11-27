<?php

namespace App\Services;

use App\Http\Requests\DeliveryOrderRequest;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderLine;
use App\Models\Organization;
use App\Services\BusinessCentral\BusinessCentralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

class DeliveryOrderService
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
        DeliveryOrderRequest $doRequest,
        Company $company
    ) {
        try {
            \DB::beginTransaction();

            $doEntity = DeliveryOrder::where(
                "purchase_order_no",
                $doRequest->purchase_order_no
            )
                ->where("is_complete", 0)
                ->where("user_id", $doRequest->user()->id)
                ->firstOrNew();


            $doEntity->delivery_order_no =
                htmlspecialchars($doRequest["delivery_order_no"]) ?? null;

            $doEntity->purchase_order_no = htmlspecialchars(
                $doRequest->purchase_order_no
            );

            $doEntity->order_date =
                $doRequest["order_date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(",", " ", $doRequest["order_date"])
                    )
                )
                : null;

            $doEntity->expected_receipt_date =
                $doRequest["expected_receipt_date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(
                            ",",
                            " ",
                            $doRequest["expected_receipt_date"]
                        )
                    )
                )
                : null;

            $doEntity->delivery_order_date =
                $doRequest["delivery_order_date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(
                            ",",
                            " ",
                            $doRequest["delivery_order_date"]
                        )
                    )
                )
                : null;
            $doEntity->invoice_date =
                $doRequest["invoice_date"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(",", " ", $doRequest["invoice_date"])
                    )
                )
                : null;

            $doEntity->invoice_no =
                htmlspecialchars($doRequest["invoice_no"]) ?? null;
            $doEntity->is_complete = $doRequest["is_complete"];
            $doEntity->user_id = $doRequest->user()->id;
            $doEntity->company_id = $company->id;
            $doEntity->organization_id = $company->organization_id;

            $doEntity->amount_including_vat =
                $doRequest["amount_including_vat"] ?? null;

            $doEntity->currency_code =
                htmlspecialchars($doRequest["currency_code"]) ?? null;

            $name = $doRequest->user()->unique_id;
            if ($doRequest->hasfile("delivery_attachments")) {
                $delivery_attachments = "";
                foreach ($doRequest->file("delivery_attachments") as $file) {
                    $deliveryAttach =
                        $file->storeAs(
                            "public/" . $name,
                            $file->getClientOriginalName()
                        ) . ";";
                    $deliveryDoc = Storage::disk("local")->url($deliveryAttach);
                    $delivery_attachments .= $deliveryDoc;
                }
                $doEntity->delivery_attachments = $delivery_attachments;
            }

            if ($doRequest->hasfile("invoice_attachments")) {
                $invoice_attachments = "";
                foreach ($doRequest->file("invoice_attachments") as $file) {
                    $invoiceAttach =
                        $file->storeAs(
                            "public/" . $name,
                            $file->getClientOriginalName()
                        ) . ";";
                    $invoiceDoc = Storage::disk("local")->url($invoiceAttach);
                    $invoice_attachments .= $invoiceDoc;
                }
                $doEntity->invoice_attachments = $invoice_attachments;
            }



            $doEntity->save();
            $doEntity->deliveryOrderLines()->delete();


            if (isset($doRequest["delivery_order_lines"])) {
                $doLineEntities = [];
                foreach ($doRequest["delivery_order_lines"]
                    as $deliveryOrderLine) {
                    if (
                        (isset($deliveryOrderLine["quantity_to_deliver"]) &&
                            $deliveryOrderLine["quantity_to_deliver"] > 0) ||
                        // isset($deliveryOrderLine["deliver_with_amount"]) ||
                        (isset(
                            $deliveryOrderLine["amount_to_deliver_including_sst"]
                        ) &&
                            $deliveryOrderLine["amount_to_deliver_including_sst"] > 0)
                    ) {
                        $doLineEntity = new DeliveryOrderLine();

                        if (isset($deliveryOrderLine["line_no"])) {
                            $doLineEntity->line_no = htmlspecialchars(
                                $deliveryOrderLine["line_no"]
                            );
                        }

                        if (isset($deliveryOrderLine["type"])) {
                            $doLineEntity->type = htmlspecialchars(
                                $deliveryOrderLine["type"]
                            );
                        }

                        if (isset($deliveryOrderLine["no"])) {
                            $doLineEntity->no = htmlspecialchars(
                                $deliveryOrderLine["no"]
                            );
                        } else {
                            $doLineEntity->no = "_blank_";
                        }

                        if (isset($deliveryOrderLine["description"])) {
                            $doLineEntity->description = htmlspecialchars(
                                $deliveryOrderLine["description"]
                            );
                        }
                        if (isset($deliveryOrderLine["location_code"])) {
                            $doLineEntity->location_code = htmlspecialchars(
                                $deliveryOrderLine["location_code"]
                            );
                        }
                        if (isset($deliveryOrderLine["quantity"])) {
                            $doLineEntity->quantity = htmlspecialchars(
                                $deliveryOrderLine["quantity"]
                            );
                        }
                        // if (isset($deliveryOrderLine["uom"])) {
                        //     $doLineEntity->uom = htmlspecialchars(
                        //         $deliveryOrderLine["uom"]
                        //     );
                        // }
                        if (
                            isset($deliveryOrderLine["unit_cost_including_sst"])
                        ) {
                            $doLineEntity->unit_cost_including_sst = htmlspecialchars(
                                $deliveryOrderLine["unit_cost_including_sst"]
                            );
                        }
                        if (isset($deliveryOrderLine["amount_including_sst"])) {
                            $doLineEntity->amount_including_sst = htmlspecialchars(
                                $deliveryOrderLine["amount_including_sst"]
                            );
                        }
                        if (isset($deliveryOrderLine["quantity_to_deliver"])) {
                            $doLineEntity->quantity_to_deliver = htmlspecialchars(
                                $deliveryOrderLine["quantity_to_deliver"]
                            );
                        }
                        if (isset($deliveryOrderLine["quantity_delivered"])) {
                            $doLineEntity->quantity_delivered = htmlspecialchars(
                                $deliveryOrderLine["quantity_delivered"]
                            );
                        }

                        // if (isset($deliveryOrderLine["quantity_to_invoice"])) {
                        //     $doLineEntity->quantity_to_invoice = htmlspecialchars(
                        //         $deliveryOrderLine["quantity_to_invoice"]
                        //     );
                        // }
                        if (isset($deliveryOrderLine["quantity_invoiced"])) {
                            $doLineEntity->quantity_invoiced = htmlspecialchars(
                                $deliveryOrderLine["quantity_invoiced"]
                            );
                        }
                        if (isset($deliveryOrderLine["outstanding_quantity"])) {
                            $doLineEntity->outstanding_quantity = htmlspecialchars(
                                $deliveryOrderLine["outstanding_quantity"]
                            );
                        }
                        if (isset($deliveryOrderLine["outstanding_amount"])) {
                            $doLineEntity->outstanding_amount = htmlspecialchars(
                                $deliveryOrderLine["outstanding_amount"]
                            );
                        }

                        if (isset($deliveryOrderLine["deliver_with_amount"])) {
                            $doLineEntity->deliver_with_amount = filter_var(
                                $deliveryOrderLine["deliver_with_amount"],
                                FILTER_VALIDATE_BOOLEAN,
                                FILTER_NULL_ON_FAILURE
                            );
                        }
                        if (
                            isset(
                                $deliveryOrderLine["amount_to_deliver_including_sst"]
                            )
                        ) {
                            $doLineEntity->amount_to_deliver_including_sst = htmlspecialchars(
                                $deliveryOrderLine["amount_to_deliver_including_sst"]
                            );
                        }
                        if (isset($deliveryOrderLine["amount_delivered"])) {
                            $doLineEntity->amount_delivered = htmlspecialchars(
                                $deliveryOrderLine["amount_delivered"]
                            );
                        }
                        if (isset($deliveryOrderLine["progress_billing"])) {
                            $doLineEntity->progress_billing = filter_var(
                                $deliveryOrderLine["progress_billing"],
                                FILTER_VALIDATE_BOOLEAN
                            ) ? 1 : 0;
                        }
                        if (isset($deliveryOrderLine["progress_billing_amount"])) {
                            $doLineEntity->progress_billing_amount = htmlspecialchars(
                                $deliveryOrderLine["progress_billing_amount"]
                            );
                        }
                        if (isset($deliveryOrderLine["unit_of_measure_code"])) {
                            $doLineEntity->unit_of_measure_code = htmlspecialchars(
                                $deliveryOrderLine["unit_of_measure_code"]
                            );
                        }
                        $doLineEntity->purchase_order_no = htmlspecialchars(
                            $doRequest->purchase_order_no
                        );

                        array_push($doLineEntities, $doLineEntity);
                    }
                }
                $doEntity->deliveryOrderLines()->saveMany($doLineEntities);
            }

            \DB::commit();
            $doEntity->delivery_order_lines = $doLineEntities;
            return $doEntity;
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function show(Request $request, Company $company)
    {
        try {
            $submittedDeliveryOrderLines = DeliveryOrderLine::whereHas(
                "DeliveryOrder",
                function ($q) use ($request) {
                    return $q->where([
                        ["purchase_order_no", $request->purchase_order_no],
                        ["is_complete", 1],
                        ["user_id", $request->user()->id],
                    ]);
                }
            )->get();

            $deliveryOrderLineMap = [];

            foreach ($submittedDeliveryOrderLines
                as $submittedDeliveryOrderLine) {
                if (
                    isset(
                        $deliveryOrderLineMap[$submittedDeliveryOrderLine->no]
                    )
                ) {
                    array_push(
                        $deliveryOrderLineMap[$submittedDeliveryOrderLine->no],
                        $submittedDeliveryOrderLine
                    );
                } else {
                    $deliveryOrderLineMap[$submittedDeliveryOrderLine->no] = [
                        $submittedDeliveryOrderLine,
                    ];
                }
            }

            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }
            $navRes = self::getPurchaseOrderDetails(
                $request->purchase_order_no,
                $organization
            );

            $draftDeliveryOrder = DeliveryOrder::with("deliveryOrderLines")
                ->where([
                    ["purchase_order_no", $request->purchase_order_no],
                    ["is_complete", 0],
                    ["user_id", $request->user()->id],
                ])
                ->first();

            $draftDeliveryOrderLineMap = [];

            if ($draftDeliveryOrder) {
                $draftDeliveryOrder = (object) $draftDeliveryOrder->toArray();
                $navRes->delivery_order_no =
                    $draftDeliveryOrder->delivery_order_no;
                $navRes->delivery_order_date =
                    $draftDeliveryOrder->delivery_order_date;
                $navRes->delivery_attachments =
                    $draftDeliveryOrder->delivery_attachments;
                $navRes->invoice_no = $draftDeliveryOrder->invoice_no;
                $navRes->invoice_date = $draftDeliveryOrder->invoice_date;
                $navRes->invoice_attachments =
                    $draftDeliveryOrder->invoice_attachments;
                $navRes->currency_code = $draftDeliveryOrder->currency_code;

                foreach ($draftDeliveryOrder->delivery_order_lines
                    as $deliveryOrderLine) {
                    $deliveryOrderLine = (object) $deliveryOrderLine;

                    $draftDeliveryOrderLineMap[$deliveryOrderLine->no] = $deliveryOrderLine;
                }
            }

            $delivery_order_lines = [];

            foreach ($navRes->delivery_order_lines as $deliveryOrderLine) {
                if (isset($draftDeliveryOrderLineMap[$deliveryOrderLine->no])) {
                    $deliveryOrderLine->quantity_to_deliver =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->quantity_to_deliver;
                    $deliveryOrderLine->deliver_with_amount =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]
                        ->deliver_with_amount == 1
                        ? true
                        : false;

                    $deliveryOrderLine->amount_to_deliver_including_sst =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->amount_to_deliver_including_sst;

                    $deliveryOrderLine->progress_billing = $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->progress_billing == 1 ? true : false;
                    $deliveryOrderLine->progress_billing_amount = (float)$draftDeliveryOrderLineMap[$deliveryOrderLine->no]->progress_billing_amount ?? 0;
                }  else {
                    $deliveryOrderLine->progress_billing = false;
                    $deliveryOrderLine->progress_billing_amount = 0;
                }
                // if (isset($deliveryOrderLineMap[$deliveryOrderLine->no])) {
                //     $deliveryOrderLine->submitted_do_lines =
                //         $deliveryOrderLineMap[$deliveryOrderLine->no];
                // }
                array_push($delivery_order_lines, $deliveryOrderLine);
            }

            $navRes->delivery_order_lines = $delivery_order_lines;

            return $navRes;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function showSubmitDelivery(Request $request, Company $company)
    {
        try {
            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }

            // Call Business Central
            $businessCentralService = new BusinessCentralService();
            $bcRes = $businessCentralService->getPurchaseOrderSubmitDelivery(
                $request->purchase_order_no
            );

            // Map BC response to match our structure
            $navRes = (object) [
                "key" => $bcRes->no,
                "no" => $bcRes->no,
                "buy_from_vendor_no" => $bcRes->buyFromVendorNo,
                "quote_no" => $bcRes->quoteNo,
                "order_date" => $bcRes->orderDate,
                "receipt_status" => $bcRes->receiptStatus, 
                "expected_receipt_date" => $bcRes->expectedReceiptDate,
                "currency_code" => $bcRes->currencyCode,
                "document_discount_pcnt" => $bcRes->documentDiscountPcnt,
                "total_excl_vat" => $bcRes->totalExclVat,
                "total_vat" => $bcRes->totalVat,
                "amount_including_vat" => $bcRes->amountIncludingVAT,
                "last_payment_date" => "-", // static
                "outstandingAmount" => $bcRes->totalExclVat,
                "notes_from_vendor" => $bcRes->notesFromVendor,
                "delivery_order_no" => $bcRes->deliveryOrderNo,
                "delivery_order_date" => $bcRes->deliveryOrderDate,
                "delivery_attachments" => $bcRes->attachmentDelivery,
                "invoice_no" => $bcRes->invoiceNo,
                "invoice_date" => $bcRes->invoiceDate,
                "invoice_attachments" => $bcRes->attachmentInvoice,
                "delivery_order_lines" => [], 
            ];

            // Get draft delivery order if exists
            $draftDeliveryOrder = DeliveryOrder::with("deliveryOrderLines")
                ->where([
                    ["purchase_order_no", $request->purchase_order_no],
                    ["is_complete", 0],
                    ["user_id", $request->user()->id],
                ])
                ->first();

            $draftDeliveryOrderLineMap = [];
            if ($draftDeliveryOrder) {
                $draftDeliveryOrder = (object) $draftDeliveryOrder->toArray();
                $navRes->delivery_order_no = $draftDeliveryOrder->delivery_order_no;
                $navRes->delivery_order_date = $draftDeliveryOrder->delivery_order_date;
                $navRes->delivery_attachments = $draftDeliveryOrder->delivery_attachments;
                $navRes->invoice_no = $draftDeliveryOrder->invoice_no;
                $navRes->invoice_date = $draftDeliveryOrder->invoice_date;
                $navRes->invoice_attachments = $draftDeliveryOrder->invoice_attachments;
                $navRes->currency_code = $draftDeliveryOrder->currency_code;

                foreach ($draftDeliveryOrder->delivery_order_lines as $deliveryOrderLine) {
                    $deliveryOrderLine = (object) $deliveryOrderLine;
                    $draftDeliveryOrderLineMap[$deliveryOrderLine->no] = $deliveryOrderLine;
                }
            }

            // Build delivery_order_lines from BC response
            $delivery_order_lines = [];
            foreach ($bcRes->submitDeliveryOrderLines as $line) {
                $deliveryOrderLine = (object) [
                    "no" => $line->no,
                    "line_no" => $line->lineNo,
                    "type" => $line->type,
                    "description" => $line->description,
                    "location_code" => $line->locationCode,
                    "quantity" => $line->quantity,
                    "unit_of_measure_code" => $line->unitOfMeasureCode,
                    "unit_cost_including_sst" => $line->directUnitCost,
                    "line_discount_pcnt" => $line->lineDiscountPcnt,
                    "amount_including_sst" => $line->lineAmount,
                    "sst_pcnt" => $line->sstPcnt,
                    "remarks" => $line->remarks,
                    "quantity_delivered" => $line->quantityReceived,
                    "quantity_invoiced" => $line->quantityInvoiced,
                    "outstanding_quantity" => $line->outstandingQuantity,
                    "deliver_with_amount" => null,
                    "amount_to_deliver_including_sst" => null,
                    "amount_delivered" => null,
                    "outstanding_amount" => $line->outstandingAmount,
                ];

                // If draft DO exists, override some fields
                if (isset($draftDeliveryOrderLineMap[$deliveryOrderLine->no])) {
                    $deliveryOrderLine->quantity_to_deliver =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->quantity_to_deliver;
                    $deliveryOrderLine->deliver_with_amount =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->deliver_with_amount == 1
                            ? true
                            : false;
                    $deliveryOrderLine->amount_to_deliver_including_sst =
                        $draftDeliveryOrderLineMap[$deliveryOrderLine->no]->amount_to_deliver_including_sst;
                } else {
                    // fallback to BC response
                    $deliveryOrderLine->quantity_to_deliver = $line->quantityToDeliver;
                }

                $delivery_order_lines[] = $deliveryOrderLine;
            }

            $navRes->delivery_order_lines = $delivery_order_lines;

            return $navRes;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function delete(Request $request)
    {
        try {
            $deliveryOrder = DeliveryOrder::with("deliveryOrderLines")
                ->where([
                    ["purchase_order_no", $request->purchase_order_no],
                    ["is_complete", 0],
                    ["user_id", $request->user()->id],
                ])
                ->first();

            if ($deliveryOrder) {
                $deliveryOrder->delete();
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseOrderDetails(
        string $order_number,
        Organization $organization
    ) {
        try {
            // $url = "eProcurement_PO";
            // $headers = [
            //     "Content-Type" => "text/xml",
            //     "SoapAction" =>
            //     "urn:microsoft-dynamics-schemas/page/eprocurement_po",
            // ];

            // $body =
            //     "<Envelope xmlns='http://schemas.xmlsoap.org/soap/envelope/'>
            //     <Body><Read xmlns='urn:microsoft-dynamics-schemas/page/eprocurement_po'>
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


            $response = $businessCentralService->getPurchaseOrder($organization->unique_id, $order_number);

            if (!$response) {
                throw new \Exception($response->message, $response->code);
            }

            $delivery_order_details =
                $response;
            $delivery_order_lines = [];
            $delivery_order = new stdClass();
            $delivery_order->key = $delivery_order_details->id ?? null;
            $delivery_order->purchase_order_no = $delivery_order_details->no ?? null;
            $delivery_order->document_date = $delivery_order_details->orderDate ?? null;
            $delivery_order->buy_from_vendor_no = $delivery_order_details->buyFromVendorNo ?? null;
            $delivery_order->vendor_quote_no = $delivery_order_details->vendorQuoteNo ?? null;
            $delivery_order->receipt_status = $delivery_order_details->receiptStatus ?? null;
            $delivery_order->expected_receipt_date = $delivery_order_details->expectedReceiptDate ?? null;
            $delivery_order->currency_code = $delivery_order_details->currencyCode ?? null;
            $delivery_order->document_discount_pcnt = $delivery_order_details->documentDiscountPcnt ?? null; 
            $delivery_order->total_excl_vat = $delivery_order_details->totalExclVat ?? null;
            $delivery_order->total_vat = $delivery_order_details->totalVat ?? null;
            $delivery_order->total_incl_vat = $delivery_order_details->amountIncludingVAT ?? null;
            $delivery_order->last_payment_date = $delivery_order_details->lastPaymentDate ?? null;
            $delivery_order->outstanding_balance = $delivery_order_details->outstandingBalance ?? null;
            $delivery_order->notes_from_vendor = $delivery_order_details->notesFromVendor ?? null;

            if (
                isset(
                    $delivery_order_details->purchaseOrderLines
                )
            ) {
                $lines =
                    $delivery_order_details->purchaseOrderLines;

                if (is_object($lines)) {
                    $lines = [$lines];
                }

                foreach ($lines as $line) {
                    $delivery_order_line = new stdClass();
                    $delivery_order_line->no = $line->no ?? null;
                    $delivery_order_line->po_line_no = $line->lineNo ?? null;
                    $delivery_order_line->type = $line->type ?? null;
                    $delivery_order_line->description = $line->description ?? null;
                    $delivery_order_line->quantity = $line->quantity ?? null;
                    $delivery_order_line->unit_of_measure_code = $line->unitOfMeasureCode ?? null;
                    $delivery_order_line->direct_unit_cost = $line->directUnitCost ?? null;
                    $delivery_order_line->line_discount_pcnt = $line->lineDiscountPcnt ?? null;
                    $delivery_order_line->sst_pcnt = $line->sstPcnt ?? null;
                    $delivery_order_line->remarks = $line->remarks ?? null;
                    $delivery_order_line->line_amount = $line->lineAmount ?? null;
                    $delivery_order_line->quantity_to_deliver = $line->quantityToDeliver ?? null;
                    $delivery_order_line->quantity_received = $line->quantityReceived ?? null;
                    $delivery_order_line->amount_delivered = $line->amountDelivered ?? null;
                    $delivery_order_line->outstanding_amount = $line->outstandingAmount ?? null;
                    $delivery_order_line->outstanding_quantity = $line->outstandingQuantity ?? null;
                    $delivery_order_line->location_code = $line->locationCode ?? null;

                    array_push($delivery_order_lines, $delivery_order_line);
                }
            }
            $delivery_order->delivery_order_lines = $delivery_order_lines;
            return $delivery_order;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getPurchaseOrderList(
        string $vendor_no,
        Organization $organization,
        $getXmlResponse = false
    ) {
        try {
            // $url = "eProcurement_PO_List";
            // $headers = [
            //     "Content-Type" => "text/xml",
            //     "SoapAction" =>
            //     "urn:microsoft-dynamics-schemas/page/eprocurement_po_list",
            // ];

            // $filters = [
            //     [
            //         "field" => "Buy_from_Vendor_No",
            //         "criteria" => $vendor_no,
            //     ],
            // ];

            // $body = SoapService::getSoapBody($filters, "eprocurement_po_list");
            // $response = SoapService::sendSoapRequest(
            //     "GET",
            //     $url,
            //     $organization,
            //     false,
            //     $headers,
            //     $body,
            //     $getXmlResponse
            // );

            $businessCentralService = new BusinessCentralService();

            $response = $businessCentralService->listOrders($organization->unique_id, $vendor_no);

            return $response;

            // if ($response->success == false) {
            //     throw new \Exception($response->message, $response->code);
            // }
            // return $response->data->SoapBody->ReadMultiple_Result
            //     ->ReadMultiple_Result;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
