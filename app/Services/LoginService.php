<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    /*
    |--------------------------------------------------------------------------
    | Login Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from Login controller
    |
    */

    /**
     * @param array $userRequest
     * @return array
     */
    public static function login(array $userRequest)
    {
        try {
            $user = User::where([
                "username" => $userRequest["username"],
                // "vendor_no" => $userRequest["vendor_no"],
            ])->first();

            if (!$user) {
                throw new \Exception("User not found", 404);
            }

            if (!$user->activated) {
                throw new \Exception("User account is deactivated", 404);
            }

            if (!Hash::check($userRequest["password"], $user->password)) {
                throw new \Exception("Password mismatch", 401);
            }

            $companies = UserService::getCompanies($user);

            if (count($companies) == 0) {
                throw new \Exception("No Company assigned to the user");
            }

            $user->setRelation("companies", []);
            $user->companies = $companies;

            $user["token"] = $user->createToken("My Token", [
                "user",
            ])->accessToken;

            $user["user_manual_url"] = url(env("USER_MANUAL_URL"));
            $user["troubleshooting_guide_url"] = url(
                env("TROUBLESHOOTING_GUIDE_URL")
            );

            return $user;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * @param  array $request
     * @return array
     */
    public static function adminLogin(array $request)
    {
        try {
            $user = Admin::where("email", $request["email"])->first();

            if (!$user) {
                throw new \Exception("User not found", 404);
            }

            if (!Hash::check($request["password"], $user->password)) {
                throw new \Exception("Password mismatch", 401);
            }

            $token = $user->createToken("My Token", ["admin", "user"])
                ->accessToken;
            return [
                "token" => $token,
                "role" => "admin",
                "name" => $user->name,
                "organization_id" => $user->organization_id,
            ];
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
