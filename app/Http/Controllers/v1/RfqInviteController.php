<?php

namespace App\Http\Controllers\v1;

use Auth;
use App\Services\v1\RfqInviteService;
use App\Http\Requests\v1\RfqInviteRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\v1\RfqMultipleInviteRequest;
use App\Http\Requests\v1\UpdatePasswordRequest;
use App\Http\Requests\v1\DeactivateVendorRequest;
use App\Http\Requests\v1\DeactivateRfqVendorRequest;
use App\Http\Controllers\v1\ApiController;

class RfqInviteController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Rfq Invite Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles storing RFQ invites for the application.The controller uses a service
    | to conveniently provide its functionality to the application.
    |
    */

    /**
     * @param RfqInviteRequest $request
     * Sends the RFQ Invitation to the concerned user
     * @return JSON
     */
    public function inviteRfq(RfqInviteRequest $request)
    {
        try {
            RfqInviteService::inviteRfq($request);
            return $this->successResponse(null, 'RFQ invitation sent successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param RfqInviteRequest $request
     * Sends the RFQ Invitation to the concerned multiple user
     * @return JSON
     */
    public function inviteMultipleRfq(RfqMultipleInviteRequest $request)
    {
        try {
            RfqInviteService::inviteMultipleRfq($request);
            return $this->successResponse(null, 'RFQ invitation sent successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param UpdatePasswordRequest $request
     * Updates the password of the user in the RFQ invites table
     * @return JSON
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            RfqInviteService::updatePassword($request);
            return $this->successResponse(null, 'Password updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param DeactivateVendorRequest $request
     * Deactivates the multiple vendor details from the RFQ invites table
     * @return JSON
     */
    public function deactivateVendor(DeactivateVendorRequest $request)
    {
        try {
            RfqInviteService::deactivateVendor($request);
            return $this->successResponse(null, 'Vendor deactivated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param DeactivateVendorRequest $request
     * Deactivates the particular vendor details from the RFQ invites table
     * @return JSON
     */
    public function deactivateRfqVendor(DeactivateRfqVendorRequest $request)
    {
        try {
            RfqInviteService::deactivateRfqVendor($request);
            return $this->successResponse(null, 'Vendor deactivated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
