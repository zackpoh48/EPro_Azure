<?php

namespace App\Services;

use App\Models\Organization;
use App\Services\BusinessCentral\BusinessCentralService;
use App\Services\SoapService;

class StatementService
{
    /*
    |--------------------------------------------------------------------------
    | Statement Service
    |--------------------------------------------------------------------------
    |
    | This service is used to get statment
    |
    */

    public static function getVendorStatements(
        string $vendorNo,
        Organization $organization
    ) {
        try {
            // For order list
            // $url = "eProcurement_Vendor_Statement";
            // $headers = [
            //     "Content-Type" => "text/xml",
            //     "SoapAction" =>
            //         "urn:microsoft-dynamics-schemas/page/eprocurement_vendor_statement",
            // ];

            // $filters = [
            //     [
            //         "field" => "Vendor_No",
            //         "criteria" => $vendorNo,
            //     ],
            // ];

            // $body = SoapService::getSoapBody(
            //     $filters,
            //     "eprocurement_vendor_statement"
            // );

            // $response = SoapService::sendSoapRequest(
            //     "GET",
            //     $url,
            //     $organization,
            //     false,
            //     $headers,
            //     $body
            // );

            $businessCentralService = new BusinessCentralService();

            $response = $businessCentralService->getVendorStatement($organization->unique_id, $vendorNo);

            if (!$response) {
                throw new \Exception($response->message, $response->code);
            }

            return $response;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
