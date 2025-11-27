<?php

namespace App\Services\BusinessCentral;

use App\Models\Company;
use App\Models\DeliveryOrder;
use App\Models\PurchaseQuote;
use App\Models\UpdatedVendorProfile;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Business Central Service
|--------------------------------------------------------------------------
|
| This service is used to connect the application with another microservice
|
*/

class BusinessCentralService
{
    private $auth = null;
    private $BaseURL = null;
    private $OAuthConfig = [];

    public function __construct()
    {
        $this->OAuthConfig = [
            "url" => env("BusinessCentralAuthURL"),
            "client_id" => env("BusinessCentralAuthClientID"),
            "client_secret" => env("BusinessCentralAuthClientSecret"),
        ];
        $this->BaseURL = env("BusinessCentralBaseURL");
        $this->auth = null;
    }

    private function sendRequest(
        $url,
        $method = "GET",
        $headers = [],
        $options = [],
        $body = null
    ) {
        try {
            $client = new Client();
            $request = new Request($method, $url, $headers, $body);

            $res = $client->sendAsync($request, $options)->wait();
            return json_decode($res->getBody());
        } catch (Exception $e) {
            return $e;
        }
    }

    public function oauth()
    {
        $headers = [
            "Content-Type" => "application/x-www-form-urlencoded",
        ];
        $options = [
            "form_params" => [
                "client_id" => $this->OAuthConfig["client_id"],
                "client_secret" => $this->OAuthConfig["client_secret"],
                "grant_type" => "client_credentials",
                "scope" => "https://api.businesscentral.dynamics.com/.default",
            ],
        ];
        return $this->sendRequest(
            $this->OAuthConfig["url"],
            "POST",
            $headers,
            $options
        );
    }

    public function listCompanies()
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "";
        return $this->sendRequest($url, "GET", $headers);
    }

    public function listQuotes(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $filterParam = "";
        if (!empty($vendorNo)) {
            $filterParam =
                '$filter=buyfromVendorNo eq \'' . urlencode($vendorNo) . '\'';
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseQuotes?" .
            $filterParam;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function getListQuotes(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }

        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];

        $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/purchaseQuote";

        return $this->sendRequest($url, "GET", $headers);
    }

    public function getPurchaseQuoteList(string $organizationId, string $vendor_no, string $status) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }

        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];

        $url = "";

        if($status == "") {
            $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/purchaseQuote";

            $query = [
                '$filter' => "buyfromVendorNo eq '{$vendor_no}'",
                '$expand' => 'purchaseQuoteLines',
            ];
        } else {
            $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/purchaseQuote";

            $query = [
                '$filter' => "buyfromVendorNo eq '{$vendor_no}' and status eq '{$status}'",
                '$expand' => 'purchaseQuoteLines',
            ];
        }

        $url .= '?' . http_build_query($query);

        // Log::info('Hitting Business Central API', [
        //     'url' => $url,
        //     'headers' => $headers,
        // ]);
        $response =  $this->sendRequest($url, "GET", $headers);
        return $response;
    }

    public function getQuote(
        string $organizationId,
        string $orderId,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseQuotes('$orderId')?" .
            $queryParams;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function listOrders(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $filterParam = "";
        if (!empty($vendorNo)) {
            $filterParam =
                '$filter=buyfromVendorNo eq \'' . urlencode($vendorNo) . '\'';
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        //url= 'https://login.microsoftonline.com/007ff11e-4640-4712-a82a-5252683505e4/oauth2/v2.0/token/($organizationId)/purchaseOrders'
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseOrders?" .
            $filterParam;

        // $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/purchaseOrders?$\filter=buyfromVendorNo eq 'VDM-003'";

        //  Log::info("ListOrders API Request", [
        //     'base_url'       => $this->BaseURL,
        //     'organizationId' => $organizationId,
        //     'vendorNo'       => $vendorNo,
        //     'filterParam'    => $filterParam,
        //     'final_url'      => $url,
        //     'headers'        => $headers,
        // ]);
        
        $response = $this->sendRequest($url, "GET", $headers);
        // Log::info("Submit Response: ", (array) $response);

        return $response;
    }

    public function getPurchaseOrder(
        string $organizationId,
        string $orderId,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        // url:https://login.microsoftonline.com/007ff11e-4640-4712-a82a-5252683505e4/oauth2/v2.0/token/($organizationId)/purchaseOrders('$orderId')?$expand=purchaseOrderLines
        
        // $url =
        //     $this->BaseURL .
        //     "($organizationId)/purchaseOrders('$orderId')?" .
        //     '$expand=purchaseOrderLines&' .
        //     $queryParams;
        
        $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/purchaseOrders('{$orderId}')?\$expand=purchaseOrderLines";
        $response = $this->sendRequest($url, "GET", $headers);

        // Log::info("PurchaseOrderView Request URL: " . $url);
        // Log::info("PurchaseOrderView Response: ", (array) $response);

        return $response;
    }

    public function getPurchaseOrderSubmitDelivery(string $orderId) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];

        $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/submitDeliveryOrders('{$orderId}')?\$expand=submitDeliveryOrderLines";

        $response = $this->sendRequest($url, "GET", $headers);

        // Log::info("Purchase Order Submit Request URL: " . $url);
        // Log::info("Purchase Order Submit Response: ", (array) $response);

        return $response;
    }

    public function listInvoices(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $filterParam = "";
        if (!empty($vendorNo)) {
            $filterParam =
                '$filter=VendorNo eq \'' . urlencode($vendorNo) . '\'';
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseInvoices?" .
            $filterParam;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function getPurchaseInvoice(
        string $organizationId,
        string $invoiceNo,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseInvoices($invoiceNo)?" .
            $queryParams;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function listCreditMemos(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $filterParam = "";
        if (!empty($vendorNo)) {
            $filterParam =
                '$filter=VendorNo eq \'' . urlencode($vendorNo) . '\'';
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseCreditMemos?" .
            $filterParam;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function getCreditMemo(
        string $organizationId,
        string $orderNo,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/purchaseCreditMemos($orderNo)?" .
            $queryParams;
        return $this->sendRequest($url, "GET", $headers);
    }

    public function getVendorStatement(string $organizationId, string $vendorNo)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $filterParam = "";
        if (!empty($vendorNo)) {
            $filterParam =
                '$filter=VendorNo eq \'' . urlencode($vendorNo) . '\'';
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/vendorStatements?" .
            $filterParam;

        $response = $this->sendRequest($url, "GET", $headers);

        // Log::info('Vendor Statement API Response', [
        //     'url' => $url,
        //     'vendorNo' => $vendorNo,
        //     'response' => $response
        // ]);

        return $response;
    }

    // POST Requests

    // Method to make POST request to create Purchase Quote
    public function createPurchaseQuote(
        $organizationId = "",
        $body,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/submitPurchaseQuotes?" .
            '$expand=submitPurchaseQuoteLines&' .
            $queryParams;
        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    // Method to make POST request to submit Delivery Order
    public function submitDeliveryOrder(
        $organizationId = "",
        $body,
        $purchaseOrderNo,
        $params = []
    ) {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];
        // $url =
        //     $this->BaseURL .
        //     "($organizationId)/submitDeliveryOrders?" .
        //     $queryParams;

        $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/submitDeliveryOrders?\$expand=submitDeliveryOrderLines";
        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    // Method to make POST request to register vendor
    public function registerVendor($organizationId = "", $body, $params = [])
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/vendorRegistrations" .
            $queryParams;
        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    //Method to make POST request to purchase quote
    public function submitPurchaseQuote($body)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }

        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];

        $url = 'https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/subPurchaseQuotes?$expand=subPurchaseQuoteLines';

        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    // Method to make POST request to update Vendor
    public function updateVendor($organizationId = "", $body, $params = [])
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }
        $queryParams = "";
        if (!empty($params)) {
            $queryParams = http_build_query($params);
        }
        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];
        $url =
            $this->BaseURL .
            "($organizationId)/vendorProfileUpdates" .
            $queryParams;
        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    //Update Vendor Profile
    public function updateVendorProfile($organizationId, $body)
    {
        if (!$this->auth) {
            $auth = $this->oauth();
            $this->auth = $auth;
        }

        $headers = [
            "Authorization" => "Bearer " . $this->auth->access_token,
            "Content-Type" => "application/json",
        ];

        // $url = $this->BaseURL . "($organizationId)/vendorProfileUpdates($vendorId)";
        $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/vendorProfileUpdates";

        return $this->sendRequest($url, "POST", $headers, [], $body);
    }

    public static function getPurchaseQuoteJSONData(
        PurchaseQuote $purchaseQuote
    ) {
        $supportArr = explode(";", $purchaseQuote->support_attachments);
        $support_attachments = "";
        foreach ($supportArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $support_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $support_attachment_files = trim($support_attachments, "|");
        $encoded_support_attachment_files = str_replace(
            " ",
            "%20",
            $support_attachment_files
        );

        $purchaseQuoteLines = $purchaseQuote
            ->purchaseQuoteLines()
            ->get()
            ->toArray();

        // Construct JSON data
        $purchaseQuoteData = (object) [
            "no" => $purchaseQuote->purchase_quote_no,
            "buyFromVendorNo" => $purchaseQuote->vendor_no,
            "documentDate" => $purchaseQuote->quotation_date,
            "expectedReceiptDate" => null,
            "paymentTermsCode" => null,
            "paymentMethodCode" => null,
            "supplierRemarks" => null,
            "locationCode" => null,
            "requisitionNo" => null,
            "rfqNo" => null,
            "yourReference" => $purchaseQuote->reference,
            "documentDiscountPcnt" => null,
            "currencyCode" => $purchaseQuote->currency,
            "lastLineNo" => $purchaseQuote->last_line_no,
            "fileAttachments" => $encoded_support_attachment_files,
            // "vendorOrderNo" => $purchaseQuote->vendor_quote_no,
            // "orderDate" => $purchaseQuote->date,
            "submitPurchaseQuoteLines" => array_map(function (
                $purchaseQuoteLine
            ) {
                return [
                    "lineNo" => $purchaseQuoteLine["line_no"],
                    "type" => null,
                    "no" => null,
                    "description" => $purchaseQuoteLine["description"],
                    "quantity" => $purchaseQuoteLine["quantity"],
                    "unitOfMeasureCode" =>
                    $purchaseQuoteLine["unit_of_measure_code"],
                    "offeredUOM" => null,
                    "directUnitCost" => $purchaseQuoteLine["direct_unit_cost"],
                    "lineDiscountPcnt" => null,
                    "notesFromVendor" => null,
                    "sstPcnt" => null,
                    // "lineAmount" => $purchaseQuoteLine['line_amount']
                ];
            }, $purchaseQuoteLines),
        ];

        // Convert PHP array to JSON
        $jsonData = json_encode($purchaseQuoteData, JSON_PRETTY_PRINT);

        return $jsonData;
    }

    public static function getDeliveryOrderJSONData(
        DeliveryOrder $deliveryOrder
    ) {
        $deliveryArr = explode(";", $deliveryOrder->delivery_attachments);
        $delivery_attachments = "";
        foreach ($deliveryArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $delivery_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $delivery_attachment_files = trim($delivery_attachments, "|");
        $encoded_delivery_attachment_files = str_replace(
            " ",
            "%20",
            $delivery_attachment_files
        );

        $invoiceArr = explode(";", $deliveryOrder->invoice_attachments);
        $invoice_attachments = "";
        foreach ($invoiceArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $invoice_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $invoice_attachment_files = trim($invoice_attachments, "|");
        $encoded_invoice_attachment_files = str_replace(
            " ",
            "%20",
            $invoice_attachment_files
        );
        $deliveryOrderLines = $deliveryOrder
            ->deliveryOrderLines()
            ->get()
            ->toArray();

        // Construct JSON data
        $deliveryQuoteData = (object) [
            "no" => $deliveryOrder->purchase_order_no,
            "orderDate" => $deliveryOrder->order_date,
            "expectedReceiptDate" => $deliveryOrder->expected_receipt_date,
            "locationCode" => null,
            "currencyCode" => $deliveryOrder->currency_code,
            // "amountIncludingVat" => $deliveryOrder->amount_including_vat,
            "deliveryOrderNo" => $deliveryOrder->delivery_order_no,
            "deliveryOrderDate" => $deliveryOrder->delivery_order_date,
            "attachmentDelivery" => $encoded_delivery_attachment_files,
            "invoiceNo" => $deliveryOrder->invoice_no,
            "invoiceDate" => $deliveryOrder->invoice_date,
            "attachmentInvoice" => $encoded_invoice_attachment_files,
            "submitDeliveryOrderLines" => array_map(function (
                $deliveryOrderLine
            ) {
                if (
                    (isset($deliveryOrderLine["quantity_to_deliver"]) &&
                        $deliveryOrderLine["quantity_to_deliver"] >= 0) ||
                    (isset(
                        $deliveryOrderLine["amount_to_deliver_including_sst"]
                    ) &&
                        $deliveryOrderLine["amount_to_deliver_including_sst"] >
                        0)
                ) {
                    $quantity_to_deliver =
                        $deliveryOrderLine["quantity_to_deliver"] ?? 0;
                    return [
                        "lineNo" => $deliveryOrderLine["line_no"],
                        "type" => $deliveryOrderLine["type"],
                        "no" => $deliveryOrderLine["no"],
                        "description" => $deliveryOrderLine["description"],
                        "locationCode" => $deliveryOrderLine["location_code"],
                        "quantity" => $deliveryOrderLine["quantity"],
                        "unitOfMeasureCode" => $deliveryOrderLine["unit_of_measure_code"],
                        "directUnitCost" =>
                        $deliveryOrderLine["unit_cost_including_sst"],
                        "quantityReceived" =>
                        $deliveryOrderLine["quantity_delivered"],
                        "quantityInvoiced" =>
                        $deliveryOrderLine["quantity_invoiced"],
                        "quantityToDeliver" => $quantity_to_deliver,
                        "outstandingQuantity" =>
                        $deliveryOrderLine["outstanding_quantity"],
                        // "deliverWithAmount" => $deliveryOrderLine['deliver_with_amount'],
                        // "amountToDeliverInclSst" => $deliveryOrderLine['amount_to_deliver_including_sst'],
                        // "amountDelivered" => $deliveryOrderLine['amount_delivered'],
                        "outstandingAmount" =>
                        $deliveryOrderLine["outstanding_amount"],
                        "amountToDeliver" => $deliveryOrderLine["progress_billing_amount"] ?? 0,
                    ];
                }
            }, $deliveryOrderLines),
        ];

        // Convert PHP array to JSON
        $jsonData = json_encode($deliveryQuoteData, JSON_PRETTY_PRINT);

        return $jsonData;
    }

    public static function getVendorRegistrationJSONData(Company $company)
    {
        $user = json_decode($company->created_by);
        // $timeStamp = new \DateTime($company->completed_at);
        // $timeStamp = $timeStamp->format("Y-m-d\TH:i:s\Z");
        $status = "Registered";
        $registrationArr = explode(
            ";",
            $company->latest_business_registration_files
        );
        $latest_business_registration_files = "";
        foreach ($registrationArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $latest_business_registration_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $business_registration_attachment = trim(
            $latest_business_registration_files,
            "|"
        );
        $encoded_business_registration_attachment = str_replace(
            " ",
            "%20",
            $business_registration_attachment
        );

        $borangArr = explode(";", $company->borang_p_files);
        $borang_p_files = "";
        foreach ($borangArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $borang_p_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $borang_p_attachment = trim($borang_p_files, "|");
        $encoded_borang_p_attachment = str_replace(
            " ",
            "%20",
            $borang_p_attachment
        );

        $formArr = explode(";", $company->form_49_files);
        $form_49_files = "";
        foreach ($formArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $form_49_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $form_49_attachment = trim($form_49_files, "|");
        $encoded_form_49_attachment = str_replace(
            " ",
            "%20",
            $form_49_attachment
        );

        $photocopyArr = explode(";", $company->photocopy_ic_files);
        $photocopy_ic_files = "";
        foreach ($photocopyArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $photocopy_ic_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $photocopy_ic_attachment = trim($photocopy_ic_files, "|");
        $encoded_photocopy_ic_attachment = str_replace(
            " ",
            "%20",
            $photocopy_ic_attachment
        );

        $statementArr = explode(";", $company->bank_statement_attachments);
        $bank_statement_attachments = "";
        foreach ($statementArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $bank_statement_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $bank_statement_attachment = trim($bank_statement_attachments, "|");
        $encoded_bank_statement_attachment = str_replace(
            " ",
            "%20",
            $bank_statement_attachment
        );

        // $supplier_pdf = explode("storage/", $user->supplier_pdf);
        // $supplierAttachment = $supplier_pdf[count($supplier_pdf) - 1];
        // $encoded_supplierAttachment = str_replace(
        //     " ",
        //     "%20",
        //     $supplierAttachment
        // );

        $vendorProfile = (object) [
            "number" => $company->vendor_no,
            "webPortalLoginId" => $user->username,
            "email" => $user->registered_email_address,
            "contact" => $user->name,
            "name" => $company->company_name,
            "name2" => "",
            "registeredAddress" => $company->registered_address_one,
            "registeredAddress2" => $company->registered_address_two,
            "mailingAddress" => $company->mailing_address_one,
            "mailingAddress2" => $company->mailing_address_two,
            "mailingCity" => $company->city,
            "mailingState" => $company->state,
            "mailingPostCode" => $company->zip_code,
            "mailingCountry" => $company->country,
            "phoneNo" => $company->tel_no,
            "faxNo" => $company->fax_no,
            "homePage" => $company->company_website,
            "typeOfIncorporation" => $company->type_of_company,
            "typeOfIncorporationOthers" => $company->type_of_company_other,
            "dateIncorporated" => $company->date_of_incorporation,
            "companyRegNo" => $company->company_reg_no,
            "vatRegistrationNo" => $company->sst_registration_no,
            "vendor_type" => $company->vendor_type,
            "tin" => $company->tin,
            "msic_code" => $company->msic_code,
            "idType" => $company->id_type,
            "idValue" => $company->id_value,
            "contactName1" => $company->contact_person_one,
            "designation1" => $company->designation_one,
            "contactName2" => $company->contact_person_two,
            "designation2" => $company->designation_two,
            "contactName3" => $company->contact_person_three,
            "designation3" => $company->designation_three,
            "annualTurnover" => null,
            "workingCapital" => null,
            "netWorth" => null,
            "cashBankBalance" => null,
            "paidUpCapital" => null,
            "productDescription1" => null,
            "productDescription2" => null,
            "productDescription3" => null,
            "productDescription4" => null,
            "productDescription5" => null,
            "productDescription6" => null,
            // "status" => $status,
            "creditTerms" => $company->credit_term_offered,
            "creditTermsOthers" => $company->credit_term_offered_other,
            "iSO9001" => null,
            "iSO14001" => null,
            "oHSAS18001" => null,
            "iSO37001" => null,
            "certificationOthers" => null,
            "certificationPleaseSpecify" => null,
            "litigationRecords" => null,
            "litigationRecordsDesc" => null,
            "corruptionFraudulent" => null,
            "corruptionFraudulentDesc" => null,
            "bankName" => $company->bank_name,
            "bankBranch" => $company->bank_branch,
            "swiftCode" => $company->swift_code,
            "bankAccountNo" => $company->bank_account_no,
            "bankAddress" => $company->bank_address_one,
            "bankAddress2" => $company->bank_address_two,
            "businessRegistrationForm" => $encoded_business_registration_attachment,
            "borangP" => $encoded_borang_p_attachment,
            "form49" => $encoded_form_49_attachment,
            "ic" => $encoded_photocopy_ic_attachment,
            // "attachmentVendorRegistration" => $encoded_bank_statement_attachment,
            "bankStatement" => $encoded_bank_statement_attachment,
            "vlod" => null,
        ];

        // Convert the object to JSON
        $jsonData = json_encode($vendorProfile, JSON_PRETTY_PRINT);

        return $jsonData;
    }

    public static function getVendorUpdateJSONData(UpdatedVendorProfile $vendor)
    {
        // $status = "Registered";
        $registrationArr = explode(
            ";",
            $vendor->latest_business_registration_files
        );
        $latest_business_registration_files = "";
        foreach ($registrationArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $latest_business_registration_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $business_registration_attachment = trim(
            $latest_business_registration_files,
            "|"
        );
        $encoded_business_registration_attachment = str_replace(
            " ",
            "%20",
            $business_registration_attachment
        );

        $borangArr = explode(";", $vendor->borang_p_files);
        $borang_p_files = "";
        foreach ($borangArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $borang_p_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }

        $borang_p_attachment = trim($borang_p_files, "|");
        $encoded_borang_p_attachment = str_replace(
            " ",
            "%20",
            $borang_p_attachment
        );

        $formArr = explode(";", $vendor->form_49_files);
        $form_49_files = "";
        foreach ($formArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $form_49_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $form_49_attachment = trim($form_49_files, "|");
        $encoded_form_49_attachment = str_replace(
            " ",
            "%20",
            $form_49_attachment
        );

        $photocopyArr = explode(";", $vendor->photocopy_ic_files);
        $photocopy_ic_files = "";
        foreach ($photocopyArr as $file) {
            $linkExplode = explode("storage/", $file);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $photocopy_ic_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $photocopy_ic_attachment = trim($photocopy_ic_files, "|");
        $encoded_photocopy_ic_attachment = str_replace(
            " ",
            "%20",
            $photocopy_ic_attachment
        );

        $statementArr = explode(";", $vendor->bank_statement_attachments);
        $bank_statement_attachments = "";
        foreach ($statementArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $bank_statement_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $bank_statement_attachment = trim($bank_statement_attachments, "|");
        $encoded_bank_statement_attachment = str_replace(
            " ",
            "%20",
            $bank_statement_attachment
        );

        // Define the vendor profile object
        $vendorProfile = (object) [
            // 'Key' => 'No',
            "number" => $vendor->vendor_no,
            "webPortalLoginId" => $vendor->username,
            "email" => $vendor->registered_email_address,
            "contact" => $vendor->name,
            "name" => $vendor->company_name,
            "name2" => null,
            "registeredAddress" => $vendor->registered_address_one,
            "registeredAddress2" => $vendor->registered_address_two,
            "mailingAddress" => $vendor->mailing_address_one,
            "mailingAddress2" => $vendor->mailing_address_two,
            "mailingCity" => $vendor->city,
            "mailingState" => $vendor->state,
            "mailingPostCode" => $vendor->zip_code,
            "mailingCountry" => $vendor->country,
            "phoneNo" => $vendor->tel_no,
            "faxNo" => $vendor->fax_no,
            "homePage" => $vendor->company_website,
            "typeOfIncorporation" => $vendor->type_of_company,
            "typeOfIncorporationOthers" => $vendor->type_of_company_other,
            "dateIncorporated" => $vendor->date_of_incorporation,
            "companyRegNo" => $vendor->company_reg_no,
            "vatRegistrationNo" => $vendor->sst_registration_no,
            // "tin" => null,
            // "idType" => null,
            // "idValue" => null,
            "contactName1" => $vendor->contact_person_one,
            "designation1" => $vendor->designation_one,
            "contactName2" => $vendor->contact_person_two,
            "designation2" => $vendor->designation_two,
            "contactName3" => $vendor->contact_person_three,
            "designation3" => $vendor->designation_three,
            // "annualTurnover" => null,
            // "workingCapital" => null,
            // "netWorth" => null,
            // "cashBankBalance" => null,
            // "paidUpCapital" => null,
            // "productDescription1" => null,
            // "productDescription2" => null,
            // "productDescription3" => null,
            // "productDescription4" => null,
            // "productDescription5" => null,
            // "productDescription6" => null,
            "creditTerms" => $vendor->credit_term_offered,
            "creditTermsOthers" => $vendor->credit_term_offered_other,
            // "iSO9001" => null,
            // "iSO14001" => null,
            // "oHSAS18001" => null,
            // "iSO37001" => null,
            // "certificationOthers" => null,
            // "certificationPleaseSpecify" => null,
            // "litigationRecords" => null,
            // "litigationRecordsDesc" => null,
            // "corruptionFraudulent" => null,
            // "corruptionFraudulentDesc" => null,
            "bankName" => $vendor->bank_name,
            "bankBranch" => $vendor->bank_branch,
            "swiftCode" => $vendor->swift_code,
            "bankAccountNo" => $vendor->bank_account_no,
            "bankAddress" => $vendor->bank_address_one,
            "bankAddress2" => $vendor->bank_address_two,
            "businessRegistrationForm" => $encoded_business_registration_attachment,
            "borangP" => $encoded_borang_p_attachment,
            "form49" => $encoded_form_49_attachment,
            "ic" => $encoded_photocopy_ic_attachment,
            "bankStatement" => $encoded_bank_statement_attachment,
            // "vlod" => null,
        ];

        // Convert the object to JSON
        $jsonData = json_encode($vendorProfile, JSON_PRETTY_PRINT);

        return $jsonData;
    }

    public static function getSupplierJSONData($supplier)
    {
        $value = $supplier;
        $cert = explode(",", $value->certification);
        $personName = $value->vendorInfo->person_name;
        $status = "Registered";
        $vendorRegisNo = $value->vendorInfo->vendor_regis_no;
        $iso9001 = in_array("ISO 9001", $cert) ? true : false;
        $iso14001 = in_array("ISO-14001", $cert) ? true : false;
        $iso45001 = in_array("OHSAS 18001 / ISO 45001", $cert) ? true : false;
        $iso37001 = in_array("ISO 37001", $cert) ? true : false;
        $otherSpecify = in_array("other", $cert) ? true : false;
        $otherCertificate = isset($value->certification_other) ? true : false;
        $companyArr = explode(";", $value->company_profile_files);
        $company_profile_files = "";

        foreach ($companyArr as $comp) {
            $linkExplode = explode("storage/", $comp);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $company_profile_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $company_attachment = trim($company_profile_files, "|");
        $encoded_company_attachment = str_replace(
            " ",
            "%20",
            $company_attachment
        );

        $productArr = explode(";", $value->product_files);
        $product_files = "";

        foreach ($productArr as $prod) {
            $linkExplode = explode("storage/", $prod);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $product_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $product_attachment = trim($product_files, "|");
        $encoded_product_attachment = str_replace(
            " ",
            "%20",
            $product_attachment
        );

        $certificateArr = explode(";", $value->certification_files);
        $certification_files = "";

        foreach ($certificateArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $certification_files .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $certificate_attachment = trim($certification_files, "|");
        $encoded_certificate_attachment = str_replace(
            " ",
            "%20",
            $certificate_attachment
        );
        // $productCatalogue = explode("storage/", $value->product_catalogue);
        // $prodcatAttachment = $productCatalogue[count($productCatalogue) - 1];
        // $encoded_prodcatAttachment = str_replace(
        //     " ",
        //     "%20",
        //     $prodcatAttachment
        // );

        $productCatalogueArr = explode(";", $value->product_catalogue);
        $product_catalogue_files = "";

        foreach ($productCatalogueArr as $prodcat) {
            $linkExplode = explode("storage/", $prodcat);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $product_catalogue_files .= $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $prodcatAttachment = trim($product_catalogue_files, "|");
        $encoded_prodcatAttachment = str_replace(" ", "%20", $prodcatAttachment);

        $statementArr = explode(";", $value->bank_statement_attachments);
        $bank_statement_attachments = "";
        foreach ($statementArr as $cert) {
            $linkExplode = explode("storage/", $cert);
            if (strlen($linkExplode[count($linkExplode) - 1])) {
                $bank_statement_attachments .=
                    $linkExplode[count($linkExplode) - 1] . "|";
            }
        }
        $bank_statement_attachment = trim($bank_statement_attachments, "|");
        $encoded_bank_statement_attachment = str_replace(
            " ",
            "%20",
            $bank_statement_attachment
        );

        $declaration_by_supplier = explode(
            "storage/",
            $value->declaration_by_supplier
        );
        $declarationSupplierAttachment =
            $declaration_by_supplier[count($declaration_by_supplier) - 1];
        $encoded_declarationSupplierAttachment = str_replace(
            " ",
            "%20",
            $declarationSupplierAttachment
        );

        $supplier_pdf = explode("storage/", $value->supplier_pdf);
        $supplierAttachment = $supplier_pdf[count($supplier_pdf) - 1];
        $encoded_supplierAttachment = str_replace(
            " ",
            "%20",
            $supplierAttachment
        );

        $supplierData = (object) [
            "number" => $vendorRegisNo,
            "webPortalLoginId" => "",
            "email" => $value->email_address,
            "contact" => $personName,
            "name" => $value->name_of_company,
            "name2" => "",
            "registeredAddress" => $value->registered_address_one,
            "registeredAddress2" => $value->registered_address_two,
            "registeredAddCity" => $value->city,
            "registeredAddState" => $value->state,
            "registeredAddCountry" => $value->country,
            "registeredAddZipCode" => $value->zip_code,
            "mailingAddressSameAsRegisteredAddress" => $value->mailing_address_same_as_registered_address == 1 ? true : false,
            "mailingAddress" => $value->mailing_address_one,
            "mailingAddress2" => $value->mailing_address_two,
            "mailingCity" => $value->mailing_address_city,
            "mailingState" => $value->mailing_address_state,
            "mailingPostCode" => $value->mailing_address_zip_code,
            "mailingCountry" => $value->mailing_address_country,
            "phoneNo" => $value->tel_no,
            "faxNo" => $value->fax_no,
            "homePage" => $value->company_website,
            "typeOfIncorporation" => $value->type_of_company,
            "typeOfIncorporationOthers" => $value->type_of_company_other,
            "dateIncorporated" => $value->date_of_incorporation,
            "companyRegNo" => $value->company_reg_no,
            "vatRegistrationNo" => $value->sst_registration_no,
            "tin" => $value->tin,
            "msicCode" => $value->msic_code,
            "accountType" => $value->account_type,
            "idType" =>  $value->id_type,
            "idValue" => $value->id_value,
            "contactName1" => $value->contact_person_one,
            "designation1" => $value->designation_one,
            "contactName2" => $value->contact_person_two,
            "designation2" => $value->designation_two,
            "contactName3" => $value->contact_person_three,
            "designation3" => $value->designation_three,
            "annualTurnover" => (float) $value->annual_turnover,
            "workingCapital" => (float) $value->working_capital,
            "netWorth" => (float) $value->net_worth,
            "cashBankBalance" => (float) $value->cash_bank_balance,
            "paidUpCapital" => (float) $value->paid_up_capital,
            "productDescription1" => $value->product_desc_one,
            "productDescription2" => $value->product_desc_two,
            "productDescription3" => $value->product_desc_three,
            "productDescription4" => $value->product_desc_four,
            "productDescription5" => $value->product_desc_five,
            "productDescription6" => $value->product_desc_six,
            "creditTerms" => $value->credit_term_offered,
            "creditTermsOthers" => $value->credit_term_offered_other,
            "iSO9001" => $iso9001,
            "iSO14001" => $iso14001,
            "oHSAS18001" => $iso45001,
            "iSO37001" => $iso37001,
            "certificationOthers" => $otherCertificate,
            "certificationPleaseSpecify" => $value->certification_other,
            "litigationRecords" => (bool) (int) $value->litigation_records,
            "litigationRecordsDesc" => $value->litigation_records_other,
            "corruptionFraudulent" => (bool) (int) $value->corruption_fraudulent_records,
            "corruptionFraudulentDesc" => $value->corruption_fraudulent_records_other,
            "bankName" => $value->bank_name,
            "bankBranch" => $value->bank_branch,
            "swiftCode" => $value->swift_code,
            "bankAccountNo" => $value->bank_account_no,
            "bankAddress" => $value->bank_address_one,
            "bankAddress2" => $value->bank_address_two,
            // "status" => $status,
            // "attachmentSectionA" => $encoded_company_attachment,
            // "attachmentSectionC1" => $encoded_prodcatAttachment,
            // "attachmentSectionC2" => $encoded_product_attachment,
            // "businessRegistrationForm" => $encoded_declarationSupplierAttachment,
            // "borangP" => "",
            // "form49" => "",
            "attachment1" => $encoded_company_attachment,
            "attachment2" => $encoded_prodcatAttachment,
            "attachment3" => $encoded_product_attachment,
            "attachment4" => $encoded_certificate_attachment,
            "attachment5" => $encoded_declarationSupplierAttachment,
            "attachment6" => $encoded_supplierAttachment,
            // "ic" => $encoded_certificate_attachment,
            "bankStatement" => $encoded_bank_statement_attachment,
            // "vlod" => $encoded_supplierAttachment,
        ];

        $jsonData = json_encode($supplierData, JSON_PRETTY_PRINT);

        return $jsonData;
    }
}
