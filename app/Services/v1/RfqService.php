<?php

namespace App\Services\v1;

use App\Models\Rfq;
use App\Http\Requests\v1\RfqRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\RfqItem;
use App\Models\RfqSubmission;

class RfqService
{
    /*
    |--------------------------------------------------------------------------
    | RFQ Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from RFQ controller
    |
    */

    /**
     * @param RfqRequest $$r
     * Stores the initial RFQ data in the database table
     * @return JSON
     */
    public static function store(RfqRequest $r)
    {
        try {
            $user = $r->user();
            $organization = $user->organization;
            //  Organization::where(
            //     "unique_id",
            //     $user->organization_id
            // )->first();
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }

            // Retrieve the RFQ if it exists
            $rfq = Rfq::where('rfq_id', $r['rfq_id'])->first();

            // Check if the RFQ exists and belongs to the same organization as the user
            if ($rfq && $rfq->organization_id !== $organization->id) {
                throw new \Exception("RFQ already exist with this uuid", 409);
            }

            \DB::beginTransaction();

            $rfq = Rfq::firstOrNew([
                'rfq_id' => $r['rfq_id'],
            ]);
            // $rfq = new Rfq();
            $rfq->rfq_id = $r['rfq_id'];
            $rfq->date_of_rfq = $r['date_of_rfq'];
            $rfq->priority = $r['priority'];
            $rfq->date_of_expiry = $r['date_of_expiry'];
            $rfq->quotation_no = $r['quotation_no'];
            $rfq->buyer_remarks = $r['buyer_remarks'];
            $rfq->tender_title = $r['tender_title'];
            $rfq->delivery_code = $r['delivery_code'];
            $rfq->currency = $r['currency_code'];
            $rfq->delivery_location = $r['delivery_location'];
            $rfq->status = (isset($r['status']) && in_array($r['status'], [0, 1])) ? $r['status'] : 1;
            $rfq->organization_id = $organization->id;
            $rfq->save();

            RfqItem::whereRfqId($r['rfq_id'])->delete();
            if (isset($r['items'])) {

                foreach ($r['items'] as $key => $value) {
                    $rfq_d = new RfqItem;
                    $rfq_d->rfq_id = $r['rfq_id'];
                    $rfq_d->item_description = $value['item_desc'];
                    $rfq_d->s_no = $value['s_no'];
                    $rfq_d->item_no = $value['item_no'];
                    $rfq_d->item_expected_delivery = $value['days'];
                    $rfq_d->qty = $value['qty'];
                    $rfq_d->uom = $value['uom'];
                    $rfq_d->save();
                }
            }
            \DB::commit();
            return $rfq;
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Retrieves details of particular RFQ with items
     * @return JSON
     */
    public static function getRfqDetails(Request $request)
    {
        try {
            $user = $request->user('rfq_invite');
            $rfq = RfqSubmission::where([
                'user_id' => $user->id,
                'rfq_id' =>  $request->rfq_id,
                'status' => 0
            ])->with('items')->first();

            if ($rfq) $rfq['submission'] = 0; // Edit draft mode
            else {
                $rfq = Rfq::where('rfq_id', $request->rfq_id)->with('items')->first();
                $rfq['submission'] = 1; // New submission mode
            }
            return json_decode(str_replace('&quot;', '\"', html_entity_decode(json_encode($rfq), ENT_NOQUOTES)));
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Retrieves details of particular RFQ with items
     * @return JSON
     */
    public static function getUserRfqDetails(Request $request)
    {
        try {
            // $user = $request->user('rfq_invite');
            $user = $request->user();
            $rfq = RfqSubmission::where([
                'user_id' => $user->id,
                'rfq_id' =>  $request->rfq_id,
                'status' => 0
            ])->with('items')->first();

            if ($rfq) $rfq['submission'] = 0; // Edit draft mode
            else {
                $rfq = $user->rfqs()->where('rfqs.rfq_id', $request->rfq_id)->with('items')->first();
                $rfq['submission'] = 1; // New submission mode
            }
            return json_decode(str_replace('&quot;', '\"', html_entity_decode(json_encode($rfq), ENT_NOQUOTES)));
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Retrieves lists of all RFQs of the particular user (To do)
     * @return JSON
     */
    public static function getRfqList(Request $request)
    {
        try {
            $user = auth('rfq_invite')->user();
            $rfq = Rfq::where('rfq_id', $user->rfq_id)->with('submissions')->firstOrFail();
            return $rfq;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getUserRfqList(Request $request)
    {
        try {
            $user = $request->user();
            // $rfqs = Rfq::where('rfq_id', $user->rfq_id)->where('supplier_id', $user->id)->with('submissions')->firstOrFail();
            $rfqs = $user->rfqs()->with('submissions')->get();
            return $rfqs;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Deactivate  RFQ Id
     * @return JSON
     */
    public static function rfqDeactivate(Request $request)
    {
        try {
            $rfq = Rfq::where('rfq_id', $request->rfq_id)->first();
            if ($rfq) {
                $rfq->status = !$rfq->status;
                $rfq->save();
            }
            return $rfq;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
