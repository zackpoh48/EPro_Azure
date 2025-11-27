<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Models\Company;
use App\Models\Organization;
use App\Services\StatementService;
use App\Exports\ExportVendorStatement;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

class StatementController extends Controller
{
    use ApiResponse;

    public function getVendorStatements(Company $company)
    {
        try {
            if ($company->status !== StatusEnum::Approved->value) {
                throw new \Exception("Company not approved", 401);
            }

            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }
            $response = StatementService::getVendorStatements(
                $company->vendor_no,
                $organization
            );

            return $this->successResponse(
                $response,
                "Get vendor statements successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getVendorStatementsExport(Company $company)
    {
        try {
            if ($company->status !== StatusEnum::Approved->value) {
                throw new \Exception("Company not approved", 401);
            }

            $organization = Organization::find($company->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }
            return Excel::download(
                new ExportVendorStatement($company->vendor_no, $organization),
                "vendor-statement.pdf"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
