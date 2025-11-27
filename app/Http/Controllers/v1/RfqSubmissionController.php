<?php

namespace App\Http\Controllers\v1;

// use Illuminate\Http\Request;
use App\Services\v1\RfqSubmissionService;
use App\Http\Controllers\v1\ApiController;
use App\Http\Requests\v1\RfqSubmissionRequest;
use App\Services\BusinessCentral\BusinessCentralService;
use Illuminate\Http\Request;

class RfqSubmissionController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Rfq Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles storing RFQ for the application.The controller uses a service
    | to conveniently provide its functionality to the application.
    |
    */

    /**
     * Updates submission data that the supplier has filled for the RFQ
     * @return JSON
     */
    public function updateRfqDetails(RfqSubmissionRequest $request)
    {
        try {
            RfqSubmissionService::update($request);
            return $this->successResponse([], 'RFQ updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function createSubPurchaseQuoteLines(Request $request)
    {
        $businessCentralService = new BusinessCentralService();
        
        try {
            $response =  $businessCentralService->submitPurchaseQuote($request->all());
            return $this->successResponse($response,'Sub Purchase Quote created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(),500);
        }
    }


}
