<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ApiResponse;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    /**
     * Handle reset password
     */
    public function callResetPassword(Request $request)
    {
        try {
            $request->validate($this->rules());

            // Here we will attempt to reset the user's password. If it is successful we
            // will update the password on an actual user model and persist it to the
            // database. Otherwise we will parse the error and return the response.
            $updatePassword = DB::table("password_reset_tokens")
                ->where([
                    "email" => $request->email,
                    "token" => $request->token,
                ])
                ->first();

            if (!$updatePassword) {
                throw new \Exception("Failed, Invalid Token.", 400);
            }

            $user = User::where([
                "registered_email_address" => $updatePassword->email,
                // "vendor_no" => $updatePassword->vendor_no,
            ])->first();


            $user->password = Hash::make($request->password);
            $user->is_password_updated = true;
            $user->save();

            DB::table("password_reset_tokens")
                ->where([
                    "email" => $request->email,
                    "token" => $request->token,
                ])
                ->delete();

            return $this->successResponse(null, "Password reset successfully.");
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public function callUpdatePassword(Request $request)
    {
        try {
            $request->validate($this->updatePasswordRules());
            $user = $request->user();

            if (!Hash::check($request["current_password"], $user->password)) {
                throw new \Exception("Current Password mismatch", 401);
            }

            $user->password = Hash::make($request->password);
            $user->is_password_updated = true;
            $user->save();
            return $this->successResponse(
                null,
                "Password updated successfully."
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            "email" => "required|email",
            "token" => "required",
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ];
    }

    /**
     * Get the password upate validation rules.
     *
     * @return array
     */
    protected function updatePasswordRules()
    {
        return [
            "current_password" => "required",
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ];
    }
}
