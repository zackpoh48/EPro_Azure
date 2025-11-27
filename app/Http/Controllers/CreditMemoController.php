<?php

namespace App\Http\Controllers;

use App\Services\CreditMemoService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CreditMemoController extends Controller
{
    use ApiResponse;

    public function getCreditMemo(Request $request)
    {
        try {
            $res = null;
            //For credit memo details
            if ($request->has("credit_memo_no")) {
                $res = CreditMemoService::getCreditMemoDetails(
                    $request->query("credit_memo_no")
                );
            } else {
                // For credit memo list
                $res = CreditMemoService::getCreditMemoList(
                    $request->user()->vendor_no
                );
            }

            return $this->successResponse($res, "Get credit memo successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
