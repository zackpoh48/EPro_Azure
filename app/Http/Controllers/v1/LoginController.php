<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\v1\LoginService;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\admin\LoginRequest as AdminLoginRequest;
use App\Http\Controllers\v1\ApiController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to the specified screen. The controller uses a service
    | to conveniently provide its functionality to your applications.
    |
    */
    use SendsPasswordResetEmails;


    /**
     * @param LoginRequest $request
     * Login function for invited vendor
     * @return JSON
     */
    public function login(LoginRequest $request)
    {
        try {
            $res = LoginService::login($request->input());
            return $this->successResponse($res, 'Login successful');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param AdminLoginRequest $request
     * Login function for admin
     * @return JSON
     */
    public function adminLogin(AdminLoginRequest $request)
    {
        try {
            $res = LoginService::adminLogin($request->input());
            return $this->successResponse($res, 'Login successful');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Logout function for revoking auth token
     * @return JSON
     */
    public function logout(Request $request)
    {
        try {
            $request->user('rfq_invite')->token()->revoke();
            return $this->successResponse(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Admin logout function for revoking auth token
     * @return JSON
     */
    public function adminLogout(Request $request)
    {
        try {
            $request->user('admin-api')->token()->revoke();
            return $this->successResponse(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Send password reset link. 
     */
    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $response,
            'status_code' => 200
        ]);
    }
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Email could not be sent to this email address.', 'status_code' => 500]);
    }
}
