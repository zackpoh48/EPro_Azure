<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\VendorInviteService;
use App\Http\Requests\v1\VendorInviteRequest;
use App\Http\Controllers\v1\ApiController;
use Illuminate\Http\Request;
use App\Mail\SendGrid;

class VendorInviteController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Vendor Invite Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles storing Vendor invites for the application.The controller uses a service
    | to conveniently provide its functionality to the application.
    |
    */

    /**
     * @param VendorInviteRequest $request
     * Sends the vendor invitation
     * @return JSON
     */
    public function inviteVendor(VendorInviteRequest $request)
    {
        try {
            $uniqueId = VendorInviteService::inviteVendor($request);
            $registrationLink = env('APP_URL') . "/register/$uniqueId";
            return $this->successResponse('Vendor invited successfully', $registrationLink);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
