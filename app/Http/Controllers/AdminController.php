<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\UnAssignCompanyRequest;
use App\Http\Requests\UpdateUserRegisterRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\MsicCode;
use App\Models\Organization;
use App\Services\AdminService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    use ApiResponse;

    public function store(OrganizationRequest $request)
    {
        try {
            $res = AdminService::store($request);
            return $this->successResponse(
                $res,
                "Organization updated successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getApiToken()
    {
        try {
            $accessToken = base64_encode(
                env("API_SERVICE_CLIENT_ID") .
                    ":" .
                    env("API_SERVICE_CLIENT_SECRET")
            );

            return $this->successResponse(
                $accessToken,
                "Get API token successfully"
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateUser(UpdateUserRegisterRequest $request)
    {
        try {
            $res = AdminService::updateUser($request);
            return $this->successResponse($res, "User updated successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getStates(Country $country)
    {
        try {
            return $this->successResponse(
                $country->states()->get(),
                "Get states successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getCountries(Request $request)
    {
        try {
            return $this->successResponse(
                Country::all(),
                "Get countries successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getAllCountries() {
        try {
            $countries = Country::orderBy('name')->select('code', 'name')->get();
            return $this->successResponse($countries, "Fetched countries list successfully");
        }
        catch(\Exception $e) {
            Log::error("Error in getAllCountries" . $e->getMessage());
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getAllStates() {
        try {
            $states = State::select('code', 'name')->get();
            return $this->successResponse($states, "Fetched states list successfully");
        }
        catch(\Exception $e) {
            Log::error("Error in getAllStates" . $e->getMessage());
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getAllMsicCodes(Request $request) {
        try {
            $query = MsicCode::query();

            if (!empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }

            $msicCodes = $query->select('code', 'description')->get();

            return $this->successResponse($msicCodes, 'MSIC Codes fetched successfully');
        } 
        catch (\Exception $e) {
            Log::error("Error in getAllMsicCodes: " . $e->getMessage());
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getCountryCodes(Request $request)
    {
        try {
            $response = Http::get(
                "https://sdk.myinvois.hasil.gov.my/files/CountryCodes.json"
            );

            // Check if the request was successful
            if ($response->successful()) {
                // Assuming the API returns a JSON response with country codes
                $countries = $response->json();

                return $this->successResponse(
                    $countries,
                    "Get countries successfully"
                );
            } else {
                return $this->errorResponse(
                    "Failed to fetch countries",
                    $response->status()
                );
            }
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function getMsicCodes(Request $request)
    {
        try {
            $response = Http::get(
                "https://sdk.myinvois.hasil.gov.my/files/MSICSubCategoryCodes.json"
            );

            if ($response->successful()) {
                $msicCodes = $response->json();

                return $this->successResponse(
                    $msicCodes,
                    "Get MSIC Codes successfully"
                );
            } else {
                return $this->errorResponse(
                    "Failed to fetch MSIC Codes",
                    $response->status()
                );
            }
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function unAssignCompany(UnAssignCompanyRequest $request)
    {
        try {
            $organisation = Organization::where(
                "unique_id",
                $request->organization_id
            )->first();
            if (!$organisation) {
                throw new \Exception("Organization not found", 404);
            }

            AdminService::unAssignCompany($request, $organisation);
            return $this->successResponse(
                null,
                "Unassign company successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function updateCompany(Request $request)
    {
        try {
            AdminService::updateCompany($request);
            return $this->successResponse(null, "Company updated successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function updateCompanyStatus(Request $request)
    {
        try {
            $organisation = Organization::where(
                "unique_id",
                $request->organization_id
            )->first();
            if (!$organisation) {
                throw new \Exception("Organization not found", 404);
            }

            AdminService::updateCompanyStatus($request, $organisation);
            return $this->successResponse(
                null,
                "Company status changed successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function updateCompanyStatusNew(Request $request)
    {
        try {
            // Log::info('Incoming updateCompanyStatusNew request', $request->all());

            $request->validate([
                'organization_id' => 'required|string',
                'vendor_no'       => 'required|string',
                'status'          => 'required|integer',
            ]);

            $organization = Organization::where('unique_id', $request->organization_id)->first();
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }

            AdminService::updateCompanyStatus($request, $organization);

            // Log::info('Company status updated successfully', [
            //     'vendor_no' => $request->vendor_no,
            //     'status' => $request->status
            // ]);

            return $this->successResponse(null, 'Company status changed successfully');
        } catch (\Exception $e) {
            Log::error('Error in updateCompanyStatusNew: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);

            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function updateCompanyStatusViaEncodedLink(Request $request)
    {
        $secret = env('PUBLIC_API_SECRET', 'default_shared_key');

        try {
            $payload = $request->query('payload');
            $signature = $request->query('signature');

            if (!$payload || !$signature) {
                throw new \Exception('Missing payload or signature.', 400);
            }

            $expectedSignature = hash_hmac('sha256', $payload, $secret);
            if (!hash_equals($expectedSignature, $signature)) {
                throw new \Exception('Invalid signature.', 401);
            }

            $json = base64_decode($payload);
            $data = json_decode($json, true);

            if (
                empty($data['vendor_no']) ||
                empty($data['status']) ||
                empty($data['organization_id'])
            ) {
                throw new \Exception('Invalid data inside payload.', 422);
            }

            $organization = Organization::where('unique_id', $data['organization_id'])->first();
            if (!$organization) {
                throw new \Exception('Organization not found', 404);
            }

            $updateRequest = new Request([
                'vendor_no' => $data['vendor_no'],
                'status' => $data['status'],
            ]);

            AdminService::updateCompanyStatus($updateRequest, $organization);

            return response()->json([
                'success' => true,
                'message' => 'Company status updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
