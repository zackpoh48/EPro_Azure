<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Http\Requests\DeliveryOrderRequest;
use App\Models\Company;
use App\Models\Organization;
use App\Services\BusinessCentral\BusinessCentralService;
use App\Services\DeliveryOrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    use ApiResponse;

    public function store(DeliveryOrderRequest $request)
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }
            $res = DeliveryOrderService::store($request, $company);
            return $this->successResponse(
                $res,
                "Delivery order created successfully"
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
            $res = DeliveryOrderService::show($request, $company);
            return $this->successResponse(
                $res,
                "DO with DO lines retrieved successfully"
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
            DeliveryOrderService::delete($request);
            return $this->successResponse(null, "Draft removed successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getPurchaseOrders(Company $company, $order_number = null)
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
            //For order details
            if ($order_number) {
                $res = DeliveryOrderService::getPurchaseOrderDetails(
                    $order_number,
                    $organization
                );
            } else {
                // For order list
                $res = DeliveryOrderService::getPurchaseOrderList(
                    $company->vendor_no,
                    $organization
                );
            }

            return $this->successResponse(
                $res,
                "Get purchage order successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function testConnection(Request $request)
    {
        try {
            $user = $request->user();
            $organization = Organization::find($user->organization_id);
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }
            //For order details

            $res = DeliveryOrderService::getPurchaseOrderList(
                $request->vendor_no,
                $organization,
                true
            );

            return $this->successResponse(
                $res,
                "Get purchage order xml successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
