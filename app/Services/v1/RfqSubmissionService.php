<?php

namespace App\Services\v1;

use App\Models\Rfq;
use App\Models\RfqItem;
use App\Models\RfqSubmission;
use Illuminate\Http\Request;
use App\Models\RfqItemSubmission;
use Illuminate\Support\Facades\Storage;
use Auth;

class RfqSubmissionService
{
    /*
    |--------------------------------------------------------------------------
    | RFQ Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from RFQ Submission controller
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
            \DB::beginTransaction();
            $rfq = new Rfq;
            $rfq->rfq_id = $r['rfq_id'];
            $rfq->date_of_rfq = $r['date_of_rfq'];
            $rfq->priority = $r['priority'];
            $rfq->date_of_expiry = $r['date_of_expiry'];
            $rfq->quotation_no = $r['quotation_no'];
            $rfq->buyer_remarks = $r['buyer_remarks'];
            $rfq->tender_title = $r['tender_title'];
            $rfq->status = 0;
            $rfq->save();

            $finalItems = [];
            foreach (json_decode($r['items']) as $data) {
                array_push($finalItems, $data);
            }
            foreach ($finalItems as $key => $value) {
                $rfq_d = new RfqItemSubmission();
                $rfq_d->rfq_id = $r['rfq_id'];
                $rfq_d->item_description = $value->item_desc;
                $rfq_d->item_no = $value->item_no;
                $rfq_d->item_expected_delivery = $value->days;
                $rfq_d->save();
            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $r
     * Creates RFQ submission for a particular user (To do)
     * @return JSON
     */
    public static function update($request)
    {
        try {
            $r = $request->input();
            $user = $request->user();
            \DB::beginTransaction();

            $rfq = $user->rfqs()->where('rfqs.rfq_id', $request->rfq_id)->with('items')->first();

            if ($rfq) {
                $rs = RfqSubmission::firstOrNew([
                    'rfq_id' => $r['rfq_id'],
                    'status' => 0,
                    'user_id' => $request->user()->id,
                ]);
                $rfqId = $r['rfq_id'];
                $vendorNo = $r['vendor_no'];
                $vendorQuotationNo = $r['vendor_quotation_no'];

                $folderName = $rfqId . '-' . $vendorNo . '-' . $vendorQuotationNo;
                $quotation = ['quotation_0', 'quotation_1', 'quotation_2'];
                $rs->quotation_files = "";
                foreach ($quotation as $quot) {
                    if ($request->hasFile($quot)) {
                        $file = $request->file($quot);
                        $fileName = $file->getClientOriginalName();

                        $path = $file->storeAs('public/' . $folderName, $fileName);

                        $publicPath = Storage::url($path);

                        $rs->quotation_files .= $publicPath . ";";
                    }
                }

                $newSubmission = !$rs->exists;

                // Initial RFQ data
                $rs->date_of_rfq = $rfq['date_of_rfq'];
                $rs->priority = $rfq['priority'];
                $rs->date_of_expiry = $rfq['date_of_expiry'];
                $rs->quotation_no = $rfq['quotation_no'];
                $rs->buyer_remarks = $rfq['buyer_remarks'];
                $rs->tender_title = $rfq['tender_title'];

                // Supplier filled RFQ data
                $rs->delivery_date = ($r['delivery_date'] != null) ? date('Y-m-d', strtotime($r['delivery_date'])) : null;
                $rs->offer_validity = ($r['offer_validity'] != null) ? date('Y-m-d', strtotime($r['offer_validity'])) : null;
                $rs->quality = $r['quality'] ?? null;
                $rs->pay_terms = $r['pay_terms'] ?? null;
                $rs->advance_paid = $r['advance_paid'] ?? null;
                $rs->vendor_number = $r['vendor_no'];
                $rs->vendor_quotation_no = $r['vendor_quotation_no'] ?? null;
                $rs->currency = $r['currency'] ?? null;
                $rs->supplier_remarks = htmlspecialchars($r['supplier_remarks']) ?? null;
                $rs->delivery_location = htmlspecialchars($r['delivery_location']) ?? null;
                $rs->delivery_code = $r['delivery_code'] ?? null;
                $rs->document_discount = $r['document_discount'] ?? null;
                $rs->user_id = $request->user()->id;
                $rs->status = $r['status'] ?? 0;
                $rs->save();

                foreach ($r['items'] as $key => $value) {

                    if (!$newSubmission) {
                        $rfq_item_submission = RfqItemSubmission::whereId($value['id'])->first();
                    } else {
                        $rfq_details = RfqItem::where(['rfq_id' => $r['rfq_id'], 'id' => $value['id']])->first();
                        $rfq_item_submission = new RfqItemSubmission;
                        $rfq_item_submission->rfq_id = $r['rfq_id'];
                        $rfq_item_submission->rfq_submission_id = $rs->id;

                        // Initial RFQ Item data
                        $rfq_item_submission->item_description = $rfq_details['item_description'];
                        $rfq_item_submission->s_no = $rfq_details['s_no'];
                        $rfq_item_submission->item_no = $rfq_details['item_no'];
                        $rfq_item_submission->item_expected_delivery = $rfq_details['item_expected_delivery'];
                        $rfq_item_submission->qty = $rfq_details['qty'];
                        $rfq_item_submission->uom = $rfq_details['uom'];
                    }

                    // Supplier filled RFQ item data
                    $rfq_item_submission->quality = $value['quality'] ?? null;
                    $rfq_item_submission->offer_qty = $value['offer_qty'] ?? null;
                    $rfq_item_submission->cost = $value['cost'] ?? null;
                    $rfq_item_submission->discount = $value['discount'] ?? 0.00;
                    $rfq_item_submission->sst = $value['sst'] ?? null;
                    $rfq_item_submission->offer_uom = htmlspecialchars($value['offer_uom']) ?? null;
                    $rfq_item_submission->remarks = htmlspecialchars($value['remarks']) ?? null;

                    if ($value['is_submitting'] == 0) {
                        $rfq_item_submission->quality = null;
                        $rfq_item_submission->offer_qty = null;
                        $rfq_item_submission->cost = null;
                        $rfq_item_submission->discount = 0.00;
                        $rfq_item_submission->sst = null;
                        $rfq_item_submission->offer_uom = null;
                        $rfq_item_submission->remarks = null;
                    }
                    $rfq_item_submission->is_submitting = $value['is_submitting'];
                    $rfq_item_submission->save();
                }
            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
