<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Company;
use App\Models\Organization;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class UserController extends Controller
{
    use ApiResponse;

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
            $request = new GuzzleRequest($method, $url, $headers, $body);

            $res = $client->sendAsync($request, $options)->wait();
            return json_decode($res->getBody());
        } catch (\Exception $e) {
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
    public function store(UserRegisterRequest $request)
    {
        try {
            $organisation = Organization::where(
                "unique_id",
                $request->organization_id
            )->first();
            if (!$organisation) {
                throw new \Exception("Organization not found", 404);
            }

            $res = UserService::store($request, $organisation);
            return $this->successResponse($res->data, $res->message);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            $user = $request->user();

            if (!($company->status == StatusEnum::Draft->value || $company->status == StatusEnum::Rejected->value)) {
                throw new \Exception("Company already submitted", 400);
            }

            if (
                !DB::table("user_companies")->where([
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ])
            ) {
                throw new \Exception(
                    "Company is not assigned to the user",
                    400
                );
            }

            $response = UserService::update($request, $company);
            return $this->successResponse($response, "Company updated successfully");
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
            $company = Company::find(2);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }
            if (!$this->auth) {
                $auth = $this->oauth();
                $this->auth = $auth;
            }   
            $headers = [
                "Authorization" => "Bearer " . $this->auth->access_token,
                "Content-Type" => "application/json",
            ];

            $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/vendorProfiles({$company->company_reg_no})";

            // for testing : 
            // $url = "https://api.businesscentral.dynamics.com/v2.0/007ff11e-4640-4712-a82a-5252683505e4/uat/api/ditrolic/ep/v1.0/companies(f848974a-5e12-ef11-9f88-000d3ad1a632)/vendorProfiles('VR24-00036')";

            $urlData = $this->sendRequest($url, "GET", $headers);

            $mapping = [
                "vendor_no" => "id",
                "company_name" => "name",
                "company_reg_no" => "companyRegNo",
                "registered_address_one" => "registeredAddress",
                "registered_address_two" => "registeredAddress2",
                "mailing_address_one" => "mailingAddress",
                "mailing_address_two" => "mailingAddress2",
                "city" => "mailingCity",
                "state" => "mailingState",
                "zip_code" => "mailingPostCode",
                "country" => "mailingCountry",
                "tel_no" => "phoneNo",
                "fax_no" => "faxNo",
                "company_website" => "homePage",
                "type_of_company" => "typeOfIncorporation",
                "date_of_incorporation" => "dateIncorporated",
                "sst_registration_no" => "vatRegistrationNo",
                "contact_person_one" => "contactName1",
                "designation_one" => "designation1",
                "contact_person_two" => "contactName2",
                "designation_two" => "designation2",
                "contact_person_three" => "contactName3",
                "designation_three" => "designation3",
                "bank_name" => "bankName",
                "bank_branch" => "bankBranch",
                "bank_account_no" => "bankAccountNo",
                "swift_code" => "swiftCode",
                "bank_address_one" => "bankAddress",
                "bank_address_two" => "bankAddress2",
                "credit_term_offered" => "creditTerms",
                "vendor_type" => "vendorType",
                "tin" => "tin",
                "msic_code" => "msicCode",
                "id_type" => "idType",
                "id_value" => "idValue",
            ];

            $formatted = [];
            foreach ($mapping as $dbField => $apiField) {
                $formatted[$dbField] = $urlData->$apiField ?? null;
            }

            $final = array_merge($company->toArray(), $formatted);
            $user = $request->user();
            $final["name"] = $user->name;
            $final["username"] = $user->username;
            $final["registered_email_address"] = $user->registered_email_address;
            $final["unique_id"] = $user->unique_id;
            $final["is_password_updated"] = $user->is_password_updated;

            
            $user = $request->user();
            $company = json_decode(
                str_replace(
                    "&quot;",
                    '\"',
                    html_entity_decode(json_encode($company), ENT_NOQUOTES)
                    )
                );
                
            $company->name = $user->name;
            $company->username = $user->username;
            $company->registered_email_address =
            $user->registered_email_address;
            $company->unique_id = $user->unique_id;
            $company->is_password_updated = $user->is_password_updated;
            return $this->successResponse(
                $final,
                "User's company retrieved successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function printPdf(Request $request)
    {
        try {
            $user = $request->user();
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            if (!($company->status == StatusEnum::Draft->value || $company->status == StatusEnum::Rejected->value)) {
                throw new \Exception("Company already submitted", 400);
            }

            if (
                !DB::table("user_companies")->where([
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ])
            ) {
                throw new \Exception(
                    "Company is not assigned to the user",
                    400
                );
            }

            $url = UserService::printPdf($company);
            return $this->successResponse($url, "Pdf downloaded successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    // public function uploadPdf(Request $request)
    // {
    //     try {
    //         $user = $request->user();
    //         if ($user->status == StatusEnum::Submitted) {
    //             throw new \Exception("User already submitted", 400);
    //         }

    //         $data = UserService::uploadPdf($request);
    //         return $this->successResponse(
    //             $data,
    //             "Supplier retrieved successfully"
    //         );
    //     } catch (\Exception $e) {
    //         return $this->errorResponse(
    //             $e->getMessage(),
    //             $e->getCode() ? $e->getCode() : 500
    //         );
    //     }
    // }

    public function finalSubmit(Request $request)
    {
        try {
            $user = $request->user();
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            if (!($company->status == StatusEnum::Draft->value || $company->status == StatusEnum::Rejected->value)) {
                throw new \Exception("Company already submitted", 400);
            }

            if (
                !DB::table("user_companies")->where([
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ])
            ) {
                throw new \Exception(
                    "Company is not assigned to the user",
                    400
                );
            }

            $data = UserService::finalSubmit($company, $user);
            return $this->successResponse($data, "Submit successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $res = UserService::updateStatus($request->status, $request->token);
            return $this->successResponse(
                $res,
                "User status changed successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getFileURL(Request $request)
    {
        try {
            $res = UserService::getFileURL($request);
            return $this->successResponse(
                $res,
                "Get terms and condition file successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function updateVendorProfile(Request $request)
    {
        try {
            $user = $request->user();
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            if (
                !DB::table("user_companies")->where([
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ])
            ) {
                throw new \Exception(
                    "Company is not assigned to the user",
                    400
                );
            }

            UserService::updateVendorProfile($request, $company);
            return $this->successResponse(
                null,
                "User vendor profile processed successfully",
                202
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getCompanies(Request $request)
    {
        try {
            $companies = UserService::getCompanies($request->user());
            return $this->successResponse(
                $companies,
                "Get user's companies successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getRfqs() {}
}
