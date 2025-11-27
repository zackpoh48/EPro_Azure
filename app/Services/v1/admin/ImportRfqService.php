<?php

namespace App\Services\v1\admin;

use App\Models\Rfq;
use App\Models\RfqItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symfony\Component\HttpFoundation\Request;

class ImportRfqService implements ToModel, WithHeadingRow, WithStartRow, WithValidation,  SkipsOnError, SkipsOnFailure
{
    /*
    |--------------------------------------------------------------------------
    | Import Rfq Services
    |--------------------------------------------------------------------------
    |
    | This service handles incoming CSV from controller for the application and
	| returing json response.
    |
    */

    /** 
     * @traits Importable,SkipsErrors,SkipsFailures 
     */
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        $this->createUpdateRfq($row);
    }

    /**
     * @param array $value
     * @return boolean
     */
    public function createUpdateRfq($value)
    {
        $value['items'] = array_values(json_decode($value['items'], true));
        try {
            $request = Request::create('/api/rfq-create', 'POST', $value);
            $request->headers->set('token', base64_encode(env('API_SERVICE_CLIENT_ID') . ':' . env('API_SERVICE_CLIENT_SECRET')));
            $response = app()->handle($request);
            return $response->getContent();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return validation rules
     */
    public function rules(): array
    {
        return [
            'rfq_id'     => 'required',
            'date_of_rfq'     => 'required',
            'priority'     => 'required',
            'date_of_expiry'     => 'required',
            'quotation_no'     => 'required',
            'buyer_remarks'     => 'required',
            'tender_title'     => 'required',
            'items'     => 'required',
        ];
    }

    public function onError(\Throwable $e)
    {
    }
}
