<?php

namespace App\Http\Controllers;

use App\Services\PurchaseInvoiceService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    use ApiResponse;

    public function getPurchaseInvoices(
        Request $request,
        $invoice_number = null
    ) {
        try {
            $res = null;
            //For purchase invoice details
            if ($invoice_number) {
                $res = PurchaseInvoiceService::getPurchaseInvoiceDetails(
                    $invoice_number
                );
            } else {
                // For purchase invoice list
                $res = PurchaseInvoiceService::getPurchaseInvoiceList(
                    $request->user()->vendor_no
                );
            }

            return $this->successResponse(
                $res,
                "Get purchase invoice successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
