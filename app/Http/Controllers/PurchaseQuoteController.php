<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Http\Requests\PurchaseQuoteRequest;
use App\Models\Company;
use App\Models\Organization;
use App\Services\PurchaseQuoteService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseQuoteController extends Controller
{
    use ApiResponse;

    public function store(PurchaseQuoteRequest $request)
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }
            $res = PurchaseQuoteService::store($request, $company);
            return $this->successResponse(
                $res,
                "Purchase quote created successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function show(Request $request)
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }
            $res = PurchaseQuoteService::show($request, $company);
            return $this->successResponse(
                $res,
                "Purchase quotes retrieved successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function delete(Request $request)
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }
            PurchaseQuoteService::delete($request, $company);
            return $this->successResponse(null, "Draft removed successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getPurchaseQuotes(Company $company, $quote_number = null)
    {
        try {
            if ($company->status !== StatusEnum::Approved->value) {
                throw new \Exception("Company not approved", 401);
            }

            $res = null;
            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }
            //For Quote details
            if ($quote_number) {
                $res = PurchaseQuoteService::getPurchaseQuoteDetails(
                    $quote_number,
                    $organization
                );
            } else {
                // For Quote list

                $res = PurchaseQuoteService::getPurchaseQuoteList(
                    $company->vendor_no,
                    $organization
                );
            }

            return $this->successResponse(
                $res,
                "Get purchage quote successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getPurchaseQuotesbyVendor(Company $company, $vendor_no, Request $request) {
        try {
            if ($company->status !== StatusEnum::Approved->value) {
                throw new \Exception("Company not approved", 401);
            }

            $res = null;
            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }

            if($vendor_no !== $company->vendor_no) {
                throw new \Exception("Vendor number mismatch", 401);
            }
            // dd($company->vendor_no);
            $status = $request->has('status') ? $request->query('status') : "";

            $res = PurchaseQuoteService::getPurchaseQuoteListVendor($company->vendor_no, $organization, $status);

            return $this->successResponse($res, "Purchase quote fetched successfully");
        }
        catch(\Exception $e) {
            Log::error("Error in getPurchaseQuotesbyVendor " . $e->getMessage());
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
