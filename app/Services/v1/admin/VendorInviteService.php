<?php

namespace App\Services\admin;

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

class VendorInviteService implements ToModel, WithHeadingRow, WithStartRow, WithValidation,  SkipsOnError, SkipsOnFailure
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
        $this->inviteVendor($row);
    }

    /**
     * @param array $value
     * @return boolean
     */
    public function inviteVendor($value)
    {
        try {
            $request = Request::create('/api/invite-vendor', 'POST', $value);
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
            'email'     => 'required',
            'person_name'     => 'required',
            'company_name'     => 'required',
            'reference'    => 'required',
            'vendor_regis_no' => 'required'
        ];
    }

    public function onError(\Throwable $e)
    {
    }
}
