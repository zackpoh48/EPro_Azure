<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\v1\RfqService;
use App\Http\Requests\v1\RfqRequest;
use App\Http\Requests\v1\RfqIdDeactivationRequest;
use App\Http\Controllers\v1\ApiController;

class RfqController extends ApiController
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
     * @param RfqRequest $request
     * Stores initial read only data for the RFQ
     * @return JSON
     */
    public function store(RfqRequest $request)
    {
        try {
            $data = RfqService::store($request);
            return $this->successResponse($data['rfq_id'], 'RFQ created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Retrieves details for one particular RFQ
     * @return JSON
     */
    public function getRfqDetails(Request $request)
    {
        try {
            $data = RfqService::getUserRfqDetails($request);
            return $this->successResponse($data, "RFQ Details retrieved successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Updates data for one particular RFQ
     * @return JSON
     */
    public function updateRfqDetails(Request $request)
    {
        try {
            $data = RfqService::update($request->input());
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Retrieves full RFQ list details
     * @return JSON
     */
    public function getRfqList(Request $request)
    {
        try {
            $data = RfqService::getUserRfqList($request);
            return $this->successResponse($data, "RFQ list retrieved successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Deactivate RFQ ID
     * @return JSON
     */
    public function rfqDeactivate(RfqIdDeactivationRequest $request)
    {
        try {
            $data = RfqService::rfqDeactivate($request);
            if (!is_null($data)) {

                $message = $data->status == 1 ? 'activated' : 'deactivated';
                return $this->successResponse('', "RFQ $message successfully");
            } else
                return $this->successResponse('', "RFQ Id Does not exist");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
