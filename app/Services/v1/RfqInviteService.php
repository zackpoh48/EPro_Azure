<?php

namespace App\Services\v1;

use App\Http\Requests\v1\RfqInviteRequest;
use App\Http\Requests\v1\RfqMultipleInviteRequest;
use App\Http\Requests\v1\UpdatePasswordRequest;
use App\Http\Requests\v1\DeactivateVendorRequest;
use App\Http\Requests\v1\DeactivateRfqVendorRequest;
use App\Jobs\SendMultipleRfqInviteMailJob;
use Illuminate\Support\Facades\Hash;
use App\Models\RfqInvite;
use App\Models\Rfq;
use stdClass;

class RfqInviteService
{
    /*
    |--------------------------------------------------------------------------
    | RFQ Invite Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from RFQ invite controller
    |
    */

    public static function getRfqUsers($organization_id, $rfq_id) {
        $rfqData = Rfq::where(['id' => $rfq_id, "organization_id" => $organization_id])->first();
        return [];
    }

    /**
     * @param RfqInviteRequest $request
     * Stores RFQ invitation data in the appropriate tables
     * @return JSON
     */
    public static function inviteRfq(RfqInviteRequest $vr)
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 10);
        try {
            $rfqData = Rfq::where(['rfq_id' => $vr['rfq_id']])->first();

            if ($rfqData) {
                $ri = RfqInvite::firstOrNew([
                    'rfq_id' =>  $vr['rfq_id'],
                    'email' => $vr['email']
                ]);

                $ri->rfq_id = $vr['rfq_id'];
                $ri->person_name = $vr['person_name'];
                $ri->company_name = $vr['company_name'];
                $ri->vendor_regis_no = $vr['vendor_regis_no'];
                $ri->reference = $vr['reference'];
                $ri->email = $vr['email'];
                $ri->status = 1;

                if (!$ri->exists) {
                    $ri->password = Hash::make($password);
                    $ri->save();
                    $vendorDetails = new stdClass();
                    $vendorDetails->tender_title = $rfqData->tender_title;
                    $vendorDetails->date_of_rfq = $rfqData->created_at;
                    $vendorDetails->date_of_expiry = $rfqData->date_of_expiry;
                    $vendorDetails->password = $password;
                    $vendorDetails->email = $vr['email'];
                    $vendorDetails->reference = $vr['reference'];
                    $vendorDetails->company_name = $vr['company_name'];
                    $vendorDetails->person_name = $vr['person_name'];
                    $vendorDetails->vendor_regis_no = $vr['vendor_regis_no'];
                    $vendorDetails->rfq_id = $vr['rfq_id'];
                    $vendorDetails->template = 'emails.rfq-invite';
                    $vendorDetails->subject = 'Request for Quotation (RFQ)';
                    SendMultipleRfqInviteMailJob::dispatch($vendorDetails);
                } else {
                    $ri->save();
                }
                return true;
            } else {
                throw new \Exception('RFQ not found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param RfqInviteRequest $request
     * Stores RFQ invitation data in the appropriate tables
     * @return JSON
     */
    public static function inviteMultipleRfq(RfqMultipleInviteRequest $vr)
    {
        try {
            $rfqData = Rfq::where(['rfq_id' => $vr['rfq_id']])->first();
            $vendorEmailDetails = [];
            if ($rfqData) {
                foreach ($vr['vendors'] as $key => $vendor) {
                    $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
                    $password = substr($random, 0, 10);

                    $ri = RfqInvite::firstOrNew([
                        'rfq_id' =>  $vr['rfq_id'],
                        'email' => $vendor['email']
                    ]);

                    $ri->rfq_id = $vr['rfq_id'];
                    $ri->person_name = $vendor['person_name'];
                    $ri->company_name = $vendor['company_name'];
                    $ri->vendor_regis_no = $vendor['vendor_regis_no'];
                    $ri->reference = $vendor['reference'];
                    $ri->email = $vendor['email'];
                    $ri->status = 1;

                    if (!$ri->exists) {

                        $ri->password = Hash::make($password);
                        $ri->save();

                        $vendorDetails = new stdClass();
                        $vendorDetails->tender_title = $rfqData->tender_title;
                        $vendorDetails->date_of_rfq = $rfqData->created_at;
                        $vendorDetails->date_of_expiry = $rfqData->date_of_expiry;
                        $vendorDetails->buyer_remarks = $rfqData->buyer_remarks;
                        $vendorDetails->password = $password;
                        $vendorDetails->email = $vendor['email'];
                        $vendorDetails->reference = $vendor['reference'];
                        $vendorDetails->company_name = $vendor['company_name'];
                        $vendorDetails->person_name = $vendor['person_name'];
                        $vendorDetails->vendor_regis_no = $vendor['vendor_regis_no'];
                        $vendorDetails->rfq_id = $vr['rfq_id'];
                        $vendorDetails->template = 'emails.rfq-invite';
                        $vendorDetails->subject = 'Request for Quotation (RFQ)';

                        array_push($vendorEmailDetails, $vendorDetails);
                    } else {
                        $ri->save();
                    }
                }

                if (count($vendorEmailDetails))
                    SendMultipleRfqInviteMailJob::dispatch($vendorEmailDetails);

                return true;
            } else {
                throw new \Exception('RFQ not found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param UpdatePasswordRequest $request
     * Updates the password on the basis of email and RFQ
     * @return JSON
     */
    public static function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $update = RfqInvite::where([
                'email' => $request['email'],
                'rfq_id' => $request['rfq_id']
            ])->first();

            if ($update) {
                $update->password = Hash::make($request['password']);
                $update->save();
                return true;
            } else {
                throw new \Exception('No record found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param DeactivateVendorRequest $request
     * Deactivates the vendor on the basis of email and RFQ
     * @return JSON
     */
    public static function deactivateRfqVendor(DeactivateRfqVendorRequest $request)
    {
        try {
            $update = RfqInvite::where([
                'email' => $request['email'],
                'rfq_id' => $request['rfq_id']
            ])->first();

            if ($update) {
                $update->status = 0;
                $update->save();
                return true;
            } else {
                throw new \Exception('No record found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param DeactivateVendorRequest $request
     * Deactivates the vendor on the basis of email
     * @return JSON
     */
    public static function deactivateVendor(DeactivateVendorRequest $request)
    {
        try {
            $update = RfqInvite::where([
                'email' => $request['email']
            ])->get();
            foreach ($update as $value) {
                if ($value) {
                    RfqInvite::where('email', $value->email)->update(['status' => 0]);
                    return true;
                } else {
                    throw new \Exception('No record found');
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
