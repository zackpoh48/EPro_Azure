<?php

namespace App\Services\v1;

use App\Models\RfqInvite;
use App\Models\Admin;
use App\Models\Rfq;
use Illuminate\Support\Facades\Hash;
use Auth;

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
     * @return JSON
     */
    public static function login(array $userRequest)
    {
        try {
            $user = RfqInvite::where(['email' => $userRequest['email'], 'rfq_id' => $userRequest['rfq_id']])->first();
            if ($user) {

                if ($user->status != 0) {
                    $credentials = [
                        'email' => $userRequest['email'],
                        'rfq_id' => $userRequest['rfq_id'],
                        'password' => $userRequest['password'],
                    ];
                    if (Hash::check($userRequest['password'], $user->password)) {
                        $rfqDetails = Rfq::where('rfq_id', $user->rfq_id)->first();
                        if ($userRequest['rfq_id'] == $user->rfq_id && $rfqDetails->status == 1) {
                            if (Auth::guard('rfq_invite_session')->attempt($credentials)) {
                                $token = Auth::guard('rfq_invite_session')->user()->createToken('My Token', ['rfq_invite'])->accessToken;
                                return ['token' => $token, 'role' => 'rfq_invite', 'tnc_url' => env('TNC_URL'), 'name' => $user->person_name];
                            }
                        } else {
                            throw new \Exception('RFQ mismatch/deactivated');
                        }
                    } else {
                        throw new \Exception('Password mismatch');
                    }
                } else {
                    throw new \Exception('Your account has been deactivated');
                }
            } else {
                throw new \Exception('User not found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $userRequest
     * @return JSON
     */
    public static function adminLogin(array $userRequest)
    {
        try {
            $user = Admin::where('email', $userRequest['email'])->first();
            if ($user) {
                $credentials = [
                    'email' => $userRequest['email'],
                    'password' => $userRequest['password'],
                ];
                if (Hash::check($userRequest['password'], $user->password)) {
                    if (Auth::guard('admin')->attempt($credentials)) {
                        $token = Auth::guard('admin')->user()->createToken('My Token', ['admin'])->accessToken;
                        return ['token' => $token, 'role' => 'admin', 'name' => $user->name];
                    }
                } else {
                    throw new \Exception('Password mismatch');
                }
            } else {
                throw new \Exception('User not found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
