<?php

namespace App\Services\v1;

use App\Models\Supplier;
use App\Mail\SendGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupplierService
{
    /*
    |--------------------------------------------------------------------------
    | Supplier Service
    |--------------------------------------------------------------------------
    |
    | This service handles incoming request from Supplier controller
    |
    */

    /**
     * @param array $sd
     * Stores supplier data in the database table
     * @return JSON
     */
    public static function storeSupplierData($sd)
    {
        try {
            $s = Supplier::where('unique_id', $sd['unique_id'])->first();
            if ($s) {
                $s->name_of_company = htmlspecialchars($sd['name_of_company']) ?? null;
                $s->company_reg_no = htmlspecialchars($sd['company_reg_no']) ?? null;
                $s->registered_address_one = htmlspecialchars($sd['registered_address_one']) ?? null;
                $s->registered_address_two = htmlspecialchars($sd['registered_address_two']) ?? null;
                $s->vendor_type = !empty($sd['vendor_type']) ? htmlspecialchars($sd['vendor_type']) : null;
                $s->account_type = !empty($sd['account_type']) ? htmlspecialchars($sd['account_type']) : null;
                $s->msic_code = !empty($sd['msic_code']) ? htmlspecialchars($sd['msic_code']) : null;
                $s->id_type = !empty($sd['id_type']) ? htmlspecialchars($sd['id_type']) : null;
                $s->id_value = !empty($sd['id_value']) ? htmlspecialchars($sd['id_value']) : null;
                $s->tin = !empty($sd['tin']) ? htmlspecialchars($sd['tin']) : null;
                $s->mailing_address_one = !empty($sd['mailing_address_one']) ? htmlspecialchars($sd['mailing_address_one']) : null;
                $s->mailing_address_two = !empty($sd['mailing_address_two']) ? htmlspecialchars($sd['mailing_address_two']) : null;
                $s->mailing_address_city = !empty($sd['mailing_address_city']) ? htmlspecialchars($sd['mailing_address_city']) : null;
                $s->mailing_address_state = !empty($sd['mailing_address_state']) ? htmlspecialchars($sd['mailing_address_state']) : null;
                $s->mailing_address_country = !empty($sd['mailing_address_country']) ? htmlspecialchars($sd['mailing_address_country']) : null;
                $s->mailing_address_zip_code = !empty($sd['mailing_address_zip_code']) ? htmlspecialchars($sd['mailing_address_zip_code']) : null;
                $s->mailing_address_same_as_registered_address = $sd['mailing_address_same_as_registered_address'] == true ? 1 : 0;
                $s->city = htmlspecialchars($sd['city']) ?? null;
                $s->state = !empty($sd['state']) ? htmlspecialchars($sd['state']) : null;
                $s->zip_code = htmlspecialchars($sd['zip_code']) ?? null;
                $s->country = !empty($sd['country']) ? htmlspecialchars($sd['country']) : null;
                $s->tel_no = $sd['tel_no'] ?? null;
                $s->fax_no = htmlspecialchars($sd['fax_no']) ?? null;
                $s->company_website = htmlspecialchars($sd['company_website']) ?? null;
                $s->email_address = htmlspecialchars($sd['email_address']) ?? null;
                $s->date_of_incorporation = ($sd['date_of_incorporation'] != null) ? date('Y-m-d', strtotime(str_replace(',', ' ', $sd['date_of_incorporation']))) : null;
                $s->year_in_operation = $sd['year_in_operation'] ?? null;
                $s->sst_registration_no = htmlspecialchars($sd['sst_registration_no']) ?? null;
                $s->contact_person_one = htmlspecialchars($sd['contact_person_one']) ?? null;
                $s->designation_one = htmlspecialchars($sd['designation_one']) ?? null;
                $s->contact_person_two = htmlspecialchars($sd['contact_person_two']) ?? null;
                $s->designation_two = htmlspecialchars($sd['designation_two']) ?? null;
                $s->contact_person_three = htmlspecialchars($sd['contact_person_three']) ?? null;
                $s->designation_three = htmlspecialchars($sd['designation_three']) ?? null;
                $s->annual_turnover = $sd['annual_turnover'] ?? null;
                $s->working_capital = $sd['working_capital'] ?? null;
                $s->net_worth = $sd['net_worth'] ?? null;
                $s->cash_bank_balance = $sd['cash_bank_balance'] ?? null;
                $s->paid_up_capital = $sd['paid_up_capital'] ?? null;
                $s->product_desc_one = htmlspecialchars($sd['product_desc_one']) ?? null;
                $s->product_desc_two = htmlspecialchars($sd['product_desc_two']) ?? null;
                $s->product_desc_three = htmlspecialchars($sd['product_desc_three']) ?? null;
                $s->product_desc_four = htmlspecialchars($sd['product_desc_four']) ?? null;
                $s->product_desc_five = htmlspecialchars($sd['product_desc_five']) ?? null;
                $s->product_desc_six = htmlspecialchars($sd['product_desc_six']) ?? null;

                $s->bank_name = htmlspecialchars($sd['bank_name']) ?? null;
                $s->swift_code = htmlspecialchars($sd['swift_code']) ?? null;
                $s->bank_branch = htmlspecialchars($sd['bank_branch']) ?? null;
                $s->bank_account_no = htmlspecialchars($sd['bank_account_no']) ?? null;
                $s->bank_address_one = htmlspecialchars($sd['bank_address_one']) ?? null;
                $s->bank_address_two = htmlspecialchars($sd['bank_address_two']) ?? null;

                $s->type_of_company = $sd['type_of_company'];
                $s->type_of_company_other = htmlspecialchars($sd['type_of_company_other']) ?? null;
                $s->certification = $sd['certification'];
                $s->certification_other = htmlspecialchars($sd['certification_other']) ?? null;
                $s->credit_term_offered = $sd['credit_term_offered'];
                $s->credit_term_offered_other = htmlspecialchars($sd['credit_term_offered_other']) ?? null;
                $s->litigation_records = $sd['litigation_records'];
                $s->litigation_records_other = htmlspecialchars($sd['litigation_records_other']) ?? null;
                $s->corruption_fraudulent_records = $sd['corruption_fraudulent_records'];
                $s->corruption_fraudulent_records_other = htmlspecialchars($sd['corruption_fraudulent_records_other']) ?? null;

                $s->name = htmlspecialchars($sd['name']) ?? null;
                $s->designation = htmlspecialchars($sd['designation']) ?? null;
                $s->nric_no = htmlspecialchars($sd['nric_no']) ?? null;
                $s->date = ($sd['date'] != null) ? date('Y-m-d', strtotime(str_replace(',', ' ', $sd['date']))) : null;

                $certification = ['certificates_0', 'certificates_1', 'certificates_2'];
                $company_profile = ['profile_0', 'profile_1', 'profile_2'];
                $products = ['products_0', 'products_1', 'products_2'];
                $product_catalogue = ['product_catalogue_0', 'product_catalogue_1', 'product_catalogue_2'];
                $bank_statement = ['bank_statement_0', 'bank_statement_1', 'bank_statement_2'];
                $s->certification_files = '';
                $s->company_profile_files = '';
                $s->product_files = '';
                $s->product_catalogue = '';

                $storeFile = function ($file, $folderPath) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $originalName . '.' . $extension;

                    $counter = 2;
                    while (Storage::exists($folderPath . '/' . $fileName)) {
                        $fileName = $originalName . '(' . $counter . ').' . $extension;
                        $counter++;
                    }

                    $path = $file->storeAs($folderPath, $fileName);
                    return Storage::disk('local')->url($path);
                };

                foreach ($certification as $cert) {
                    if (isset($sd[$cert])) {
                        $s->certification_files .= $storeFile($sd[$cert], 'public/' . $sd['unique_id']);
                    }
                }

                foreach ($company_profile as $profile) {
                    if (isset($sd[$profile])) {
                        $s->company_profile_files .= $storeFile($sd[$profile], 'public/' . $sd['unique_id']);
                    }
                }

                foreach ($products as $product) {
                    if (isset($sd[$product])) {
                        $s->product_files .= $storeFile($sd[$product], 'public/' . $sd['unique_id']);
                    }
                }

                foreach ($product_catalogue as $catalogue) {
                    if (isset($sd[$catalogue])) {
                        $s->product_catalogue .= $storeFile($sd[$catalogue], 'public/' . $sd['unique_id']);
                    }
                }

                foreach ($bank_statement as $bank) {
                    if (isset($sd[$bank])) {
                        $s->bank_statement_attachments .= $storeFile($sd[$bank], 'public/' . $sd['unique_id']);
                    }
                }

                if (isset($sd['declaration_by_supplier']) && gettype($sd['declaration_by_supplier']) == "object") {
                    $s->declaration_by_supplier = $storeFile($sd['declaration_by_supplier'], 'public/' . $sd['unique_id']);
                }

                // foreach ($certification as $cert) {
                //     if (isset($sd[$cert])) {
                //         $certAttach = $sd[$cert]->storeAs('public/' . $sd['unique_id'], $sd[$cert]->getClientOriginalName()) . ";";
                //         $certDocs = Storage::disk('local')->url($certAttach);

                //         $s->certification_files .= $certDocs;
                //     }
                // }
                // foreach ($company_profile as $profile) {
                //     if (isset($sd[$profile])) {
                //         $proAttach = $sd[$profile]->storeAs('public/' . $sd['unique_id'], $sd[$profile]->getClientOriginalName()) . ";";
                //         $proDocs = Storage::disk('local')->url($proAttach);
                //         $s->company_profile_files .= $proDocs;
                //     }
                // }
                // foreach ($products as $product) {
                //     if (isset($sd[$product])) {
                //         $prodAttach = $sd[$product]->storeAs('public/' . $sd['unique_id'], $sd[$product]->getClientOriginalName()) . ";";
                //         $prodDocs = Storage::disk('local')->url($prodAttach);
                //         $s->product_files .= $prodDocs;
                //     }
                // }
                // foreach ($product_catalogue as $catalogue) {
                //     if (isset($sd[$catalogue])) {
                //         $prodAttach = $sd[$catalogue]->storeAs('public/' . $sd['unique_id'], $sd[$catalogue]->getClientOriginalName()) . ";";
                //         $prodDocs = Storage::disk('local')->url($prodAttach);
                //         $s->product_catalogue .= $prodDocs;
                //     }
                // }
                // if (isset($sd['declaration_by_supplier']) && gettype($sd['declaration_by_supplier']) == "object") {
                //     $decAttach = $sd['declaration_by_supplier']->storeAs('public/' . $sd['unique_id'], $sd['declaration_by_supplier']->getClientOriginalName());
                //     $decDocs = Storage::disk('local')->url($decAttach);

                //     $s->declaration_by_supplier = $decDocs;
                // }
                $s->is_print = 0;
                $s->is_print_upload = 0;
                $s->is_complete = 0;
                $s->save();
                return true;
            } else {
                throw new \Exception('Unique ID not found');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Gets supplier details with respect to a valid Unique ID
     * @return JSON
     */
    public static function getSupplierDetails(Request $request)
    {
        try {
            $s = self::checkValidity($request);
            if ($s) {
                return json_decode(str_replace('&quot;', '\"', html_entity_decode(json_encode($s), ENT_NOQUOTES)));
            } else {
                throw new \Exception('Invalid Unique ID');
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Checks validity of Unique ID after successful supplier form submit
     * @return JSON
     */
    public static function checkValidity(Request $request)
    {
        try {
            $s = Supplier::where('unique_id', $request->unique_id)->first();
            if ($s) return $s;
            else throw new \Exception('Invalid Unique ID');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * Checks Passcode Valid Or Not
     * @return JSON
     */
    public static function passcodeVerification(Request $request)
    {
        try {
            $s = Supplier::where('unique_id', $request->unique_id)->first();
            if ($request->passcode == $s->passcode) {
                $s->is_passcode_verified = 1;
                $s->save();
                return $s;
            } else throw new \Exception('Invalid Passcode');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param String $email
     * Sends specified email after submitting supplier form 
     * @return JSON
     */
    public static function sendEmail($vr)
    {
        try {
            $vr['template'] = 'emails.vendor-registration';
            $vr['subject'] = 'Supplier Registration Form';
            \Mail::to($vr['email_address'])->send(new SendGrid($vr));
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Array $pr
     * Sends data in pdf blade
     * @return JSON
     */
    public static function printPdf($pr)
    {
        try {
            $s = Supplier::where('unique_id', $pr['unique_id'])->first();
            if ($s) {
                $s->is_print = 1;
                $s->is_complete = 1;
                $s->save();
                return $s;
                return json_decode(str_replace('&quot;', '\"', html_entity_decode(json_encode($s), ENT_NOQUOTES)));
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Array $fr
     * Store pdf file in supplier table
     * @return JSON
     */
    public static function uploadPdf($fr)
    {
        try {
            $s = Supplier::where('unique_id', $fr['unique_id'])->first();
            if ($s) {

                // $pdfFile = $fr->file('file');
                // $pdfFileName = $pdfFile->getClientOriginalName();
                // $pdfDocs = $pdfFile->storeAs('public/' . $fr['unique_id'], $pdfFileName);
                // $getPdfFile = Storage::disk('local')->url($pdfDocs);
                // $s->supplier_pdf = $getPdfFile;
                // $s->is_print_upload = 1;
                // $s->save();

                // return $s;

                // Get the extension of the file
                $extension = $fr->file('file')->getClientOriginalExtension();

                // Remove the extension from the original name
                $nameWithoutExtension = pathinfo($fr->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

                // Sanitize the name by replacing all non-alphanumeric characters with underscores
                $nameWithoutExtension = preg_replace('/[^a-zA-Z0-9]/', '_', $nameWithoutExtension);

                // Generate a unique filename using the sanitized name, current datetime, and random string
                $uniqueName = date('Ymd_His') . '_' . Str::random(4) . '_' . $nameWithoutExtension . '.' . $extension;

                // Store the file in the storage/app/public directory
                $storedPath = $fr->file('file')->storeAs('public/' . $fr['unique_id'], $uniqueName);

                // Get the URL of the stored file
                $pdfUrl = Storage::url($storedPath);

                // Update the supplier record with the PDF file URL
                $s->supplier_pdf = $pdfUrl;
                $s->is_print_upload = 1;
                $s->save();

                return $s;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Array $fr
     * Final Submission for supplier
     * @return JSON
     */
    public static function finalSubmit($fs)
    {
        try {
            $s = Supplier::where(['unique_id' => $fs['unique_id'], 'is_print' => 1, 'is_print_upload' => 1])->first();
            if ($s) {
                $s->status = 1;
                $s->save();
                self::sendEmail($s);
                return $s;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
