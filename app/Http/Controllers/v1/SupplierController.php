<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\v1\SupplierService;
use App\Http\Requests\v1\SupplierRequest;
use App\Http\Controllers\v1\ApiController;
use App\Models\Supplier;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PDF;

class SupplierController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Supplier Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles storing supplier data for the application.The controller uses a service
    | to conveniently provide its functionality to your application.
    |
    */

    /**
     * @param SupplierRequest $request
     * Saves / Submits data from the supplier registration form
     * @return JSON
     */
    public function store(SupplierRequest $request)
    {
        try {
            SupplierService::storeSupplierData($request);
            return $this->successResponse(null, 'Supplier updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Retrieves the partially filled data by the supplier
     * @return JSON
     */
    public function getSupplierDetails(Request $request)
    {
        try {
            $data = SupplierService::getSupplierDetails($request);
            return $this->successResponse($data, 'Supplier retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function updateDisclosureAgreement(Request $request)
    {
        try {
            $unique_id = $request->input('unique_id');

            if (!$unique_id) {
                return $this->errorResponse("unique_id is required", 400);
            }

            $supplier = Supplier::where('unique_id', $unique_id)->first();

            if (!$supplier) {
                return $this->errorResponse("Supplier not found", 404);
            }

            $supplier->view_non_disclosure_agreement = now('Asia/Kuala_Lumpur');
            $supplier->save();

            return $this->successResponse($supplier->view_non_disclosure_agreement, "Disclosure agreement updated successfully");

        } catch (\Exception $e) {
            Log::error("Error in updateDisclosureAgreement: " . $e->getMessage());
            return $this->errorResponse("Error updating disclosure agreement", 500, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Action perform print pdf
     * @return JSON
     */
    public function printPdf(Request $request)
    {
        try {
            $s = SupplierService::printPdf($request);
            $org = Organization::where(
                "id",
                $s->organization_id
            )
            ->select('logo_url')
            ->first();
            // dd($org->logo_url);
            // $appCompanyLogo = env('APP_COMPANY_LOGO');
            $s['image_path'] = $org->logo_url;
            if ($s) {
                // return compact("s");
                // return $s->toArray();
                
                $pdf = PDF::loadView('pdf.v1-print-register', $s->toArray());
                // return $pdf->stream($s['unique_id'] . '.pdf');
                return $pdf->download($s['unique_id'] . '.' . 'pdf');
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Request $request
     * Action perform upload pdf
     * @return JSON
     */
    public function uploadPdf(Request $request)
    {
        try {
            $data = SupplierService::uploadPdf($request);
            return $this->successResponse($data, 'Supplier retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Final submit for supplier
     * @return JSON
     */
    public function finalSubmit(Request $request)
    {
        try {
            $data = SupplierService::finalSubmit($request);
            return $this->successResponse($data, 'Submit successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Passcode Verification
     * @return JSON
     */
    public function passcodeVerification(Request $request)
    {
        try {
            $data = SupplierService::passcodeVerification($request);
            return $this->successResponse($data, 'Verified successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
