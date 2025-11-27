<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\Mailtrap;
use App\Services\LoginService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use ApiResponse;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application.
    */

    /**
     * @param LoginRequest $request
     * Login function for invited vendor
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $res = LoginService::login($request->input());
            return $this->successResponse($res, "Login successful");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * @param AdminLoginRequest $request
     * Login function for admin
     * @return JsonResponse
     */
    public function adminLogin(AdminLoginRequest $request)
    {
        try {
            $res = LoginService::adminLogin($request->input());
            return $this->successResponse($res, "Login successful");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * @param Request $request
     * Logout function for revoking auth token
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            if ($request->role && $request->role == 'admin') {
                $request->guard('admin')->user("api")->token()->revoke();
                // $request->auth()->guard('admin')->user("api")->token()->revoke();
            } else {
                $request
                    ->user("api")
                    ->token()
                    ->revoke();
            }
            return $this->successResponse(null, "Logged out successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * @param Request $request
     * Admin logout function for revoking auth token
     * @return JsonResponse
     */
    public function adminLogout(Request $request)
    {
        try {
            $request
                ->user("admin-api")
                ->token()
                ->revoke();
            return $this->successResponse(null, "Logged out successfully");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * Send password reset link.
     */
    public function sendPasswordResetLink(ResetPasswordRequest $request)
    {
        try {
            $token = Str::random(60);


            DB::table("password_reset_tokens")->updateOrInsert(
                [
                    "email" => $request->email,
                ],
                ["token" => $token, "created_at" => Carbon::now()]
            );

            $details = [
                "token" => $token,
                "email" => $request->email,
                "template" => "mail.password-reset-email",
                "subject" => "Reset Password Notification",
            ];

            Mail::to($request->email)->send(new Mailtrap($details));


            return $this->successResponse(null, "Password reset email sent.");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
