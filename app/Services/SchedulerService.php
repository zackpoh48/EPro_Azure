<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\Organization;
use App\Models\PurchaseQuote;
use App\Models\UpdatedVendorProfile;
use App\Services\BusinessCentral\BusinessCentralService;
use App\Services\SoapService;
use Illuminate\Support\Facades\Log;
use stdClass;

class SchedulerService
{
    public function userRegisterSoapCall()
    {
        try {
            $companies = Company::where("status", StatusEnum::Submitted)
                ->where("nav_status", "!=", "Success")
                ->where("attempts", "<", 3)
                ->get();

            $navData = [];
            $organizationMap = [];
            if (count($companies)) {
                foreach ($companies as $company) {
                    // $body = SoapService::getRegistrationXmlData($company);

                    $body = BusinessCentralService::getVendorRegistrationJSONData($company);

                    // $url = "eProcurement_Vendor_Registration";
                    // $headers = [
                    //     "Content-Type" => "text/xml",
                    //     "SoapAction" =>
                    //     "urn:microsoft-dynamics-schemas/page/eprocurement_vendor_registration",
                    // ];

                    if (
                        array_key_exists(
                            $company->organization_id,
                            $organizationMap
                        )
                    ) {
                        $organization =
                            $organizationMap[$company->organization_id];
                    } else {
                        $organization = Organization::find(
                            $company->organization_id
                        );
                        $organizationMap[$organization->id] = $organization;
                    }
                    // $response = SoapService::sendSoapRequest(
                    //     "POST",
                    //     $url,
                    //     $organization,
                    //     false,
                    //     $headers,
                    //     $body
                    // );

                    $organizationId = (string) $organization->unique_id;
                    $businessCentralService = new BusinessCentralService();
                    $response = $businessCentralService->registerVendor($organizationId, $body);
                    $navRes = new stdClass();
                    $navRes->id = $company->id;
                    $navRes->soap_data = $body;
                    if (isset($response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $response->getMessage();
                    }
                    array_push($navData, $navRes);
                }
            }

            foreach ($navData as $data) {
                $company = Company::find($data->id);
                $company->nav_status = $data->nav_status;
                $company->soap_data = $data->soap_data;
                $company->fault_code = $data->fault_code ?? null;
                $company->attempts = $company->attempts + 1;
                $company->save();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deliveryOrderSoapCall()
    {
        try {
            $deliveryOrders = DeliveryOrder::where("is_complete", "=", true)
                ->where("nav_status", "!=", "Success")
                ->where("attempts", "<", 3)
                ->get();

                $navData = [];
                $organizationMap = [];
                
                if (count($deliveryOrders)) {
                    foreach ($deliveryOrders as $deliveryOrder) {
                        // $body = SoapService::getDeliveryOrderXmlData(
                            //     $deliveryOrder
                            // );
                            
                    $purchaseOrderNo = $deliveryOrder['purchase_order_no'];
                    $body = BusinessCentralService::getDeliveryOrderJSONData($deliveryOrder);

                    // $url = "eProcurement_SubmitDO";
                    // $headers = [
                    //     "Content-Type" => "text/xml",
                    //     "SoapAction" =>
                    //     "urn:microsoft-dynamics-schemas/page/eprocurement_submitdo",
                    // ];

                    if (
                        array_key_exists(
                            $deliveryOrder->organization_id,
                            $organizationMap
                        )
                    ) {
                        $organization =
                            $organizationMap[$deliveryOrder->organization_id];
                    } else {
                        $organization = Organization::find(
                            $deliveryOrder->organization_id
                        );
                        if (!$organization) {
                            throw new \Exception("Organization not found", 404);
                        }
                        $organizationMap[$organization->id] = $organization;
                    }
                    // $response = SoapService::sendSoapRequest(
                    //     "POST",
                    //     $url,
                    //     $organization,
                    //     false,
                    //     $headers,
                    //     $body
                    // );

                    $organizationId = (string) $organization->unique_id;
                    $businessCentralService = new BusinessCentralService();
                    $response = $businessCentralService->submitDeliveryOrder($organizationId, $body, $purchaseOrderNo);

                    $navRes = new stdClass();
                    $navRes->id = $deliveryOrder->id;
                    $navRes->soap_data = $body;

                    if (isset($response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $response->getMessage();
                    }
                    array_push($navData, $navRes);
                }
            }
            foreach ($navData as $data) {
                $deliveryOrder = DeliveryOrder::find($data->id);
                $deliveryOrder->nav_status = $data->nav_status;
                $deliveryOrder->soap_data = $data->soap_data;
                $deliveryOrder->fault_code = $data->fault_code ?? null;
                $deliveryOrder->attempts = $deliveryOrder->attempts + 1;
                $deliveryOrder->save();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function vendorProfileUpdateSoapCall()
    {
        try {
            $vendorProfiles = UpdatedVendorProfile::where(
                "nav_status",
                "!=",
                "Success"
            )
                ->where("attempts", "<", 3)
                ->get();

            $navData = [];
            $organizationMap = [];
            if (count($vendorProfiles)) {
                foreach ($vendorProfiles as $vendorProfile) {
                    // $body = SoapService::getVendorProfileXmlData(
                    //     $vendorProfile
                    // );

                    $body = BusinessCentralService::getVendorUpdateJSONData($vendorProfile);

                    // $url = "eProcurement_Vendor_Profile";
                    // $headers = [
                    //     "Content-Type" => "text/xml",
                    //     "SoapAction" =>
                    //     "urn:microsoft-dynamics-schemas/page/eprocurement_vendor_profile",
                    // ];

                    if (
                        array_key_exists(
                            $vendorProfile->organization_id,
                            $organizationMap
                        )
                    ) {
                        $organization =
                            $organizationMap[$vendorProfile->organization_id];
                    } else {
                        $organization = Organization::find(
                            $vendorProfile->organization_id
                        );
                        if (!$organization) {
                            throw new \Exception("Organization not found", 404);
                        }
                        $organizationMap[$organization->id] = $organization;
                    }
                    // $response = SoapService::sendSoapRequest(
                    //     "POST",
                    //     $url,
                    //     $organization,
                    //     false,
                    //     $headers,
                    //     $body
                    // );

                    $organizationId = (string) $organization->unique_id;
                    $businessCentralService = new BusinessCentralService();
                    $response = $businessCentralService->updateVendorProfile($organizationId, $body);

                    $navRes = new stdClass();
                    $navRes->id = $vendorProfile->id;
                    $navRes->soap_data = $body;

                    if (isset($response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $response->getMessage();
                    }
                    array_push($navData, $navRes);
                }
            }
            foreach ($navData as $data) {
                $vendorProfile = UpdatedVendorProfile::find($data->id);
                $vendorProfile->nav_status = $data->nav_status;
                $vendorProfile->soap_data = $data->soap_data;
                $vendorProfile->fault_code = $data->fault_code ?? null;
                $vendorProfile->attempts = $vendorProfile->attempts + 1;
                $vendorProfile->save();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function purchaseQuoteSoapCall()
    {
        try {
            $purchaseQuotes = PurchaseQuote::where("is_complete", "=", true)
                ->where("nav_status", "!=", "Success")
                ->where("attempts", "<", 3)
                ->get();

            $navData = [];
            $organizationMap = [];

            if (count($purchaseQuotes)) {
                foreach ($purchaseQuotes as $purchaseQuote) {
                    // $body = SoapService::getPurchaseQuoteXmlData(
                    //     $purchaseQuote
                    // );

                    $body = BusinessCentralService::getPurchaseQuoteJSONData($purchaseQuote);

                    // $url = "eProcurement_SubmitPQ";
                    // $headers = [
                    //     "Content-Type" => "text/xml",
                    //     "SoapAction" =>
                    //     "urn:microsoft-dynamics-schemas/page/eprocurement_submitpq",
                    // ];

                    if (
                        array_key_exists(
                            $purchaseQuote->organization_id,
                            $organizationMap
                        )
                    ) {
                        $organization =
                            $organizationMap[$purchaseQuote->organization_id];
                    } else {
                        $organization = Organization::find(
                            $purchaseQuote->organization_id
                        );
                        if (!$organization) {
                            throw new \Exception("Organization not found", 404);
                        }
                        $organizationMap[$organization->id] = $organization;
                    }
                    // $response = SoapService::sendSoapRequest(
                    //     "POST",
                    //     $url,
                    //     $organization,
                    //     false,
                    //     $headers,
                    //     $body
                    // );

                    $organizationId = (string) $organization->unique_id;
                    $businessCentralService = new BusinessCentralService();
                    $response = $businessCentralService->createPurchaseQuote($organizationId, $body);

                    $navRes = new stdClass();
                    $navRes->id = $purchaseQuote->id;
                    $navRes->soap_data = $body;

                    if (isset($response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $response->getMessage();
                    }
                    array_push($navData, $navRes);
                }
            }
            foreach ($navData as $data) {
                $purchaseQuote = PurchaseQuote::find($data->id);
                $purchaseQuote->nav_status = $data->nav_status;
                $purchaseQuote->soap_data = $data->soap_data;
                $purchaseQuote->fault_code = $data->fault_code ?? null;
                $purchaseQuote->attempts = $purchaseQuote->attempts + 1;
                $purchaseQuote->save();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
