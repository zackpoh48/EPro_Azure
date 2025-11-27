<?php

namespace App\Services\v1;

use App\Http\Requests\v1\VendorInviteRequest;
use App\Mail\SendGrid;
use App\Models\Organization;
use App\Models\VendorInvite;
use App\Models\Supplier;
use Illuminate\Support\Str;

class VendorInviteService
{
    /*
    |--------------------------------------------------------------------------
    | Vendor Invite Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from Vendor invite controller
    |
    */

    /**
     * @param VendorInviteRequest $vr
     * Stores vendor invitation data in the appropriate tables
     * @return JSON
     */
    public static function inviteVendor(VendorInviteRequest $vr)
    {
        $organisation = Organization::where(
            "unique_id",
            $vr->organization_unique_id
        )->first();
        if (!$organisation) {
            throw new \Exception("Organization not found", 404);
        }
        try {

            // Retrieve the Vendor if it exists
            $vendorInvite = VendorInvite::where('vendor_regis_no', $vr['vendor_regis_no'])->first();

            // Check if the Vendor exists and belongs to the same organization as the user
            if ($vendorInvite && $vendorInvite->organization_id !== $organization->id) {
                throw new \Exception("Vendor already exist with this uuid", 409);
            }
            
            \DB::beginTransaction();
            $uniqueId = Str::uuid();
            $passcode = $vr['passcode'];
            $r = VendorInvite::updateOrCreate(
                ['vendor_regis_no' => $vr['vendor_regis_no']],
                [
                    'email' => $vr['email'],
                    'person_name' => $vr['person_name'],
                    'reference' => $vr['reference']
                ]
            );
            $r->save();

            $s = Supplier::where('invite_id', $r->id)->first();
            if ($s) {
                $s->name_of_company = $vr['company_name'];
                $s->is_print = 0;
                $s->is_print_upload = 0;
                $s->save();
            } else {
                $s = new Supplier;
                $s->invite_id = $r->id;
                $s->unique_id = $uniqueId;
                $s->name_of_company = $vr['company_name'];
                $s->company_reg_no = $vr['vendor_regis_no'];
                $s->person_name = $vr['person_name'];
                $s->reference = $vr['reference'];
                $s->is_print = 0;
                $s->is_print_upload = 0;
                $s->status = 0;
                $s->passcode = $passcode;
                $s->organization_id = $organisation->id;
                $s->email_address = $vr['email'];
                $s->save();
                self::sendEmail($vr, $uniqueId);
            }
            \DB::commit();
            return $s->unique_id;
        } catch (\Exception $e) {
            \DB::rollback();
            echo $e;
            return $e;
        }
    }

    /**
     * @param VendorInviteRequest $details
     * Sends specified email to the invited vendor 
     * @return JSON
     */
    public static function sendEmail(VendorInviteRequest $vr, $uniqueId)
    {
        try {
            $vr['unique_id'] = $uniqueId;
            $vr['template'] = 'emails.vendor-invite';
            $vr['subject'] = 'Supplier Registration Form';
            \Mail::to($vr['email'])->send(new SendGrid($vr));
        } catch (\Exception $e) {
            return $e;
        }
    }
}
