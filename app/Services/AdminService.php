<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\UpdateUserRegisterRequest;
use App\Models\Company;
use App\Models\Organization;
use App\Models\StatusLog;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;

class AdminService
{
    /*
    |--------------------------------------------------------------------------
    | Admin Service
    |--------------------------------------------------------------------------
    |
    |
    */

    public static function store(OrganizationRequest $request)
    {
        try {
            DB::beginTransaction();

            $organisation = Organization::where(
                "id",
                ((int) $request->organization_id)
            )->firstorNew();

            if (!isset($organisation->unique_id)) {
                $organisation->unique_id = Str::uuid();
            }

            if (isset($request["name"])) {
                $organisation->name = htmlspecialchars($request["name"]);
            }

            if (isset($request["nav_username"])) {
                $organisation->nav_username = $request["nav_username"];
            }

            if (isset($request["nav_password"])) {
                $organisation->nav_password = $request["nav_password"];
            }

            if (isset($request["nav_auth"])) {
                $organisation->nav_auth = $request["nav_auth"];
            }

            if (isset($request["nav_server"])) {
                $organisation->nav_server = $request["nav_server"];
            }

            if (isset($request["nav_port"])) {
                $organisation->nav_port = $request["nav_port"];
            }

            if (isset($request["nav_environment"])) {
                $organisation->nav_environment = $request["nav_environment"];
            }

            if (isset($request["nav_company"])) {
                $organisation->nav_company = $request["nav_company"];
            }

            if (isset($request["send_registration_email"])) {
                $organisation->send_registration_email =
                    $request["send_registration_email"];
            }

            if (isset($request["logo_url"])) {
                $organisation->logo_url = $request["logo_url"];
            }

            // if ($request->hasfile("terms_and_condition_file")) {
            //     $termAttach = $request["terms_and_condition_file"]->storeAs(
            //         "public/",
            //         $request[
            //             "terms_and_condition_file"
            //         ]->getClientOriginalName()
            //     );

            //     $organisation->terms_and_condition_file = Storage::disk(
            //         "local"
            //     )->url($termAttach);
            // }

            $organisation->save();
            DB::commit();
            $organisation->terms_and_condition_file_url = asset(
                $organisation->terms_and_condition_file
            );

            return $organisation;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function updateUser(UpdateUserRegisterRequest $request)
    {
        try {
            $user = User::where([
                "unique_id" => $request->uuid,
            ])->first();

            if (!$user) {
                throw new \Exception("User not found", 404);
            }

            // if (isset($request["email"])) {
            //     $user->email = $request["email"];
            // }

            if (isset($request["activated"])) {
                $user->activated = $request["activated"];
            }

            $user->save();

            return [
                "activated" => $user->activated,
                // "email" => $user->email,
                // "vendor_no" => $user->vendor_no,
            ];
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function unAssignCompany($request, $organization): void
    {
        try {
            $user = User::where("username", $request["username"])->first();
            if (!$user) {
                throw new \Exception(
                    "User with given username does not exists!",
                    404
                );
            }

            $company = Company::where([
                "vendor_no" => $request["vendor_no"],
                "organization_id" => $organization->id,
            ])->first();

            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            $user->companies()->detach([$company->id]);
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function updateCompany(Request $request): void
    {
        try {
            $company = Company::find($request->company_id);
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            if (isset($request["vendor_no"])) {
                $company->vendor_no = $request["vendor_no"];
            }

            if (isset($request["company_name"])) {
                $company->company_name = $request["company_name"];
            }

            if (isset($request["company_reg_no"])) {
                $company->company_reg_no = $request["company_reg_no"];
            }

            if (isset($request["status"])) {
                $company->status = (int) $request["status"];

                if (
                    $company->status == StatusEnum::Rejected->value ||
                    $company->status == StatusEnum::Draft->value
                ) {
                    $company->is_print = 0;
                    $company->is_complete = 0;
                }

                StatusLog::create([
                    "reason" => "Updated By Admin",
                    "status" => $company->status,
                    "company_id" => $company->id,
                ]);
            }

            $company->save();
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function updateCompanyStatus(
        Request $request,
        Organization $organization
    ): void {
        try {
            $company = Company::where([
                "vendor_no" => $request->vendor_no,
                "organization_id" => $organization->id,
            ])->first();
            if (!$company) {
                throw new \Exception("Company not found!", 404);
            }

            if (isset($request["status"])) {
                $company->status = (int) $request["status"];

                if (
                    $company->status == StatusEnum::Rejected->value ||
                    $company->status == StatusEnum::Draft->value
                ) {
                    $company->is_print = 0;
                    $company->is_complete = 0;
                    $company->attempts = 0;
                    $company->nav_status = "created";
                }

                StatusLog::create([
                    "reason" => "Updated By Admin",
                    "status" => $company->status,
                    "company_id" => $company->id,
                ]);
            }

            $company->save();
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                is_numeric($e->getCode()) ? (int) $e->getCode() : 500
            );
        }
    }
}
