<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\v1\admin\ImportRfqService;
use App\Services\admin\UpdatePasswordService;
use App\Services\admin\VendorInviteService;
use App\Services\admin\DeactivateVendorService;
use App\Services\VendorRegisterSoapService;
use App\Services\v1\PurchaseQuoteService;
use App\Http\Controllers\v1\ApiController;
use App\Http\Requests\v1\admin\SettingRequest;
use App\Http\Requests\v1\admin\ChangePasswordRequest;
use App\Http\Requests\v1\admin\AdminRfqInviteRequest;
use App\Http\Requests\v1\admin\UpdateLogoRequest;
use App\Http\Requests\v1\admin\UpdateUserPasswordRequest;
use App\Jobs\SendMultipleRfqInviteMailJob;
use App\Models\Admin;
use App\Models\Supplier;
use App\Models\CompanyDetail;
use App\Models\Organization;
use App\Models\Rfq;
use App\Models\RfqInvite;
use App\Models\RfqSubmission;
use App\Models\User;
use App\Services\BusinessCentral\BusinessCentralService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;
use Storage;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Admin Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles CSV import request for the application. The controller uses a service
    | to conveniently provide its functionality to your applications.
    |
    */

    public function create(Request $request)
    {
        try {
            // Manually validate the email uniqueness
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|string|min:8',
                'organization_unique_id' => 'required|string',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Check if organzation exists
            $organization = Organization::where(
                "unique_id",
                $request->organization_unique_id
            )->first();
            if (!$organization) {
                throw new \Exception("Organization not found", 404);
            }

            // Create the admin
            $admin = Admin::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'organization_id' => $organization->id,
            ]);

            return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Redirects request to specified function depending on the input request
     * @return JSON
     */
    public function import(Request $request)
    {
        try {
            switch ($request->option) {
                case "1":
                case "2":
                    $this->importRfq($request);
                    break;
                case "3":
                    $this->vendorInviteByCsv($request);
                    break;
                case "4":
                    $this->passwordUpdateByCsv($request);
                    break;
                case "5":
                    $this->deactivateVendorByCsv($request);
                    break;
                default:
                    break;
            }
            return $this->successResponse(null, "Successfully imported");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Testing the RFQ import create / update and file validations
     * @return JSON
     */
    public function importRfq(Request $request)
    {
        try {
            $import = new ImportRfqService;
            $pathTofile = $request->file('file');
            $import->import($pathTofile);
            if ($import->failures()->isNotEmpty()) {
                $msg = '';
                $failures = $import->failures();
                foreach ($failures as $failure) {
                    $msg = $failure->row();
                    $msg = 'At Line no ' . $msg . ' ' . $failure->errors()[0];
                }
                return $this->errorResponse($msg, 500);
            } else {
                return $this->successResponse(null, "Successfully imported");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Testing the vendor invite API and file validations
     * @return JSON
     */
    public function vendorInviteByCsv(Request $request)
    {
        try {
            $import =  new VendorInviteService;
            $pathTofile = $request->file('file');
            $import->import($pathTofile);
            if ($import->failures()->isNotEmpty()) {
                $msg = '';
                $failures = $import->failures();
                foreach ($failures as $failure) {
                    $msg = $failure->row();
                    $msg = 'At Line no ' . $msg . ' ' . $failure->errors()[0];
                }
                return $this->errorResponse($msg, 500);
            } else {
                return $this->successResponse(null, "Successfully imported");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Testing the update password API for an RFQ vendor and file validations
     * @return JSON
     */
    public function passwordUpdateByCsv(Request $request)
    {
        try {
            $import =  new UpdatePasswordService;
            $pathTofile = $request->file('file');
            $import->import($pathTofile);
            if ($import->failures()->isNotEmpty()) {
                $msg = '';
                $failures = $import->failures();
                foreach ($failures as $failure) {
                    $msg = $failure->row();
                    $msg = 'At Line no ' . $msg . ' ' . $failure->errors()[0];
                }
                return $this->errorResponse($msg, 500);
            } else {
                return $this->successResponse(null, "Successfully imported");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * Testing the deactivate vendor API for an RFQ vendor and file validations
     * @return JSON
     */
    public function deactivateVendorByCsv(Request $request)
    {
        try {
            $import =  new DeactivateVendorService;
            $pathTofile = $request->file('file');
            $import->import($pathTofile);
            if ($import->failures()->isNotEmpty()) {
                $msg = '';
                $failures = $import->failures();
                foreach ($failures as $failure) {
                    $msg = $failure->row();
                    $msg = 'At Line no ' . $msg . ' ' . $failure->errors()[0];
                }
                return $this->errorResponse($msg, 500);
            } else {
                return $this->successResponse("Successfully imported");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Retrieves .env settings for the application
     * @return JSON
     */
    public function getSettings()
    {
        try {
            return $this->successResponse([
                'soap_url' => env('SOAP_URL'),
                'tnc_url' => env('TNC_URL'),
                'e_sign' => env('E_SIGN'),
                'nav_username' => env('NAV_USERNAME'),
                'nav_password' => env('NAV_PASSWORD'),
                'nav_authtype' => env('NAV_AUTHTYPE')
            ], "Settings retrieved successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @param SettingRequest $request
     * Updates .env settings for the application
     * @return JSON
     */
    public function updateSettings(Request $request)
    {
        try {
            file_put_contents(app()->environmentFilePath(), str_replace(
                ['E_SIGN=' . env('E_SIGN'), 'SOAP_URL=' . env('SOAP_URL'), 'TNC_URL=' . env('TNC_URL'), 'NAV_USERNAME=' . env('NAV_USERNAME'), 'NAV_PASSWORD=' . env('NAV_PASSWORD'), 'NAV_AUTHTYPE=' . env('NAV_AUTHTYPE')],
                ['E_SIGN=' . $request->e_sign, 'SOAP_URL=' . str_replace(' ', '%20', $request->soap_url), 'TNC_URL=' . str_replace(' ', '%20', $request->tnc_url), 'NAV_USERNAME=' . $request->nav_username, 'NAV_PASSWORD=' . $request->nav_password, 'NAV_AUTHTYPE=' . $request->nav_authtype],
                file_get_contents(app()->environmentFilePath())
            ));
            return $this->successResponse(null, "Settings updated successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getApiToken()
    {
        try {
            $accessToken = base64_encode(env('API_SERVICE_CLIENT_ID') . ':' . env('API_SERVICE_CLIENT_SECRET'));
            return $this->successResponse($accessToken, "Settings updated successfully");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param Request $request
     * Updates .env company logo for the application
     * @return JSON
     */
    public function updateCompanyLogo(Request $request)
    {
        try {
            $companyLogo = $request->file('company_logo');
            if ($companyLogo) {

                $companyLogoFile = $companyLogo->getClientOriginalName();
                $logo = $companyLogo->storeAs('public/company-logo', $companyLogoFile);
                $getFile = Storage::disk('local')->url($logo);
            }

            if (!isset($getFile)) {
                $getFile = env('APP_COMPANY_LOGO');
            }

            $companyDetails = CompanyDetail::firstOrCreate();
            $companyDetails->company_logo = $getFile;
            $companyDetails->company_name = $request->company_name;
            $companyDetails->company_enquiry = $request->company_enquiry;
            $companyDetails->mail_from_name = $request->mail_from_name;
            $companyDetails->save();

            // file_put_contents(
            //     app()->environmentFilePath(),
            //     str_replace(
            //         ['APP_COMPANY_LOGO=' . env('APP_COMPANY_LOGO'), 'APP_COMPANY_NAME=' . env('APP_COMPANY_NAME'), 'APP_COMPANY_ENQUIRY=' . env('APP_COMPANY_ENQUIRY'), 'MAIL_FROM_NAME=' . env('MAIL_FROM_NAME')],
            //         ['APP_COMPANY_LOGO=' . str_replace(' ', '%20', $getFile), 'APP_COMPANY_NAME=' . $request->company_name, 'APP_COMPANY_ENQUIRY=' . $request->company_enquiry, 'MAIL_FROM_NAME=' . $request->mail_from_name],
            //         file_get_contents(app()->environmentFilePath())
            //     )
            // );
            return $this->successResponse($getFile, "Company Details updated successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // public function updateOrganizationLogo(Request $request)
    // {
    //     try {
    //         $organizationLogo = $request->file('company_logo');
    //         if ($organizationLogo) {

    //             $organizationLogoFile = $organizationLogo->getClientOriginalName();
    //             $logo = $organizationLogo->storeAs('public/organization-logo', $organizationLogoFile);
    //             $getFile = Storage::disk('local')->url($logo);
    //         }

    //         // if (!isset($getFile)) {
    //         //     $getFile = env('APP_COMPANY_LOGO');
    //         // }

    //         // $companyDetails = CompanyDetail::firstOrCreate();
    //         // $companyDetails->company_logo = $getFile;
    //         // $companyDetails->company_name = $request->company_name;
    //         // $companyDetails->company_enquiry = $request->company_enquiry;
    //         // $companyDetails->mail_from_name = $request->mail_from_name;
    //         // $companyDetails->save();


    //         $organization = Organization::find(Auth::user('admin')->organization_id);
    //         $organization->logo_url = $getFile;
    //         $organization->save();

    //         // file_put_contents(
    //         //     app()->environmentFilePath(),
    //         //     str_replace(
    //         //         ['APP_COMPANY_LOGO=' . env('APP_COMPANY_LOGO'), 'APP_COMPANY_NAME=' . env('APP_COMPANY_NAME'), 'APP_COMPANY_ENQUIRY=' . env('APP_COMPANY_ENQUIRY'), 'MAIL_FROM_NAME=' . env('MAIL_FROM_NAME')],
    //         //         ['APP_COMPANY_LOGO=' . str_replace(' ', '%20', $getFile), 'APP_COMPANY_NAME=' . $request->company_name, 'APP_COMPANY_ENQUIRY=' . $request->company_enquiry, 'MAIL_FROM_NAME=' . $request->mail_from_name],
    //         //         file_get_contents(app()->environmentFilePath())
    //         //     )
    //         // );
    //         return $this->successResponse($getFile, "Company Details updated successfully");
    //     } catch (\Exception $e) {
    //         return $this->errorResponse($e->getMessage(), 500);
    //     }
    // }

    /**
     * Return .env company logo for the application
     * @return JSON
     */
    public function getCompanyLogo()
    {
        try {
            $companyDetails = CompanyDetail::first();
            // $logo = $companyDetails->company_logo ?? env('APP_COMPANY_LOGO');
            $logo = env('APP_COMPANY_LOGO');
            $company_name = $companyDetails->company_name ?? env('APP_COMPANY_NAME');
            $company_enquiry = $companyDetails->company_enquiry ?? env('APP_COMPANY_ENQUIRY');
            $mail_from_name = $companyDetails->mail_from_name ?? env('MAIL_FROM_NAME');
            return $this->successResponse([
                'logo' => $logo,
                'company_name' => $company_name,
                'company_enquiry' => $company_enquiry,
                'mail_from_name' => $mail_from_name,
            ], "Company details retrived successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getOrganizationLogo(Request $request)
    {
        try {
            $organisation = Organization::where(
                "id",
                $request->organization_id
            )
            ->select('logo_url', 'non_disclosure_agreement_url', 'vendor_letter_of_declaration_url')
            ->first();
            if (!$organisation) {
                throw new \Exception("Organization not found", 404);
            }

            return $this->successResponse(
                $organisation,
                "Organization logo retrieved successfully"
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Return name for the admin panel
     * @return JSON
     */
    public function getAdminName()
    {
        try {
            // $a = Admin::first();
            $a = Auth::user('admin');
            if ($a) {

                return $this->successResponse($a, "Logo retrived successfully");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getAdminRfqList()
    {
        try {
            $user = Auth::user('admin');
            $rfqList = Rfq::where('organization_id', $user->organization_id)->select('id', 'rfq_id')->get();
            return $this->successResponse($rfqList, "RFQ list retreived successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getAdminRfqUsers()
    {
        try {
            $user = Auth::user('admin');
            $rfqUserList = User::where('organization_id', $user->organization_id)->select('id', 'username', 'unique_id')->get();
            return $this->successResponse($rfqUserList, "RFQ User list retreived successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function submitRfqInvite(AdminRfqInviteRequest $request)
    {
        try {
            $admin = Auth::user('admin');

            $vendorEmailDetails = [];
            // Validate if RFQ exists
            $rfq = Rfq::where('rfq_id', $request->rfq_id)->where('organization_id', $admin->organization_id)->first();
            if (!$rfq) {
                throw new \Exception("RFQ not found", 404);
            }

            $users = User::where('organization_id', $admin->organization_id)->whereIn('unique_id', $request->user_ids)->select('id', 'registered_email_address')->get();
            $userIds = $users->pluck('id')->toArray();
            $attachedIds = $rfq->users()->pluck('user_id')->toArray();
            $newIds = array_diff($userIds, $attachedIds);
            // return [$userIds, $attachedIds, $newIds, ];
            $rfq->users()->attach($newIds);
            $newUsers = User::whereIn('id', $newIds)->select('id', 'registered_email_address')->get();
            foreach ($newUsers as $user) {

                $vendorDetails = new stdClass();
                $vendorDetails->org_logo = $admin->organization->logo_url;

                $vendorDetails->tender_title = $rfq->tender_title;
                $vendorDetails->date_of_rfq = $rfq->date_of_rfq;
                $vendorDetails->date_of_expiry = $rfq->date_of_expiry;
                $vendorDetails->buyer_remarks = $rfq->buyer_remarks;
                $vendorDetails->email = $user->registered_email_address;
                $vendorDetails->rfq_id = $rfq->rfq_id;
                $vendorDetails->template = 'emails.rfq-invite-new';
                $vendorDetails->subject = 'Request for Quotation (RFQ)';

                array_push($vendorEmailDetails, $vendorDetails);
            }
            if (count($vendorEmailDetails)) {
                SendMultipleRfqInviteMailJob::dispatch($vendorEmailDetails);
            }

            return $this->successResponse(null, "RFQ Invitation Sent Successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function vendorRegisterSoapCall()
    {
        try {

            $supplier = Supplier::with('vendorInfo')->where('status', '1')->where("nav_status", "!=", 'Success')->where("attempts", "<", '3')->get();
            $navData = [];
            $soapData = [];
            if (count($supplier)) {
                foreach ($supplier as $value) {

                    $body = BusinessCentralService::getSupplierJSONData($value);

                    $organization = Organization::find(
                        $value->organization_id
                    );

                    $organizationId = (string) $organization->unique_id;

                    $businessCentralService = new BusinessCentralService();
                    $nav_response = $businessCentralService->registerVendor($organizationId, $body);

                    $navRes = new stdClass();
                    $navRes->id = $value->id;
                    $navRes->soap_data = $body;
                    if (isset($nav_response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $nav_response->getMessage();
                    }
                    array_push($navData, $navRes);
                }
            }

            foreach ($navData as $data) {
                $vendor = Supplier::find($data->id);
                $vendor->nav_status = $data->nav_status;
                $vendor->soap_data =  $data->soap_data;
                $vendor->fault_code = $data->fault_code ?? null;
                $vendor->attempts = $vendor->attempts + 1;
                $vendor->save();
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function purchaseQuoteScheduler3() {
        try {
            $rfqSubmissions = RfqSubmission::with('items', 'vendorNumber')
                ->where('status', 1)
                ->where("nav_status", "!=", 'Success')
                ->where("attempts", "<", 3)
                ->get();
            $navData = [];

            if ($rfqSubmissions->count()) {
                foreach ($rfqSubmissions as $submission) {
                    
                    $body = PurchaseQuoteService::getPurchaseQuoteJSONData($submission);

                    $businessCentralService = new BusinessCentralService();
                    $nav_response = $businessCentralService->submitPurchaseQuote($body);

                    $navRes = new stdClass();
                    $navRes->id = $submission->id;
                    $navRes->soap_data = $body;

                    if (isset($nav_response->id)) {
                        $navRes->nav_status = "Success";
                    } else {
                        $navRes->nav_status = "Failed";
                        $navRes->fault_code = $nav_response->getMessage();
                    }

                    $navData[] = $navRes;
                }
            }

            foreach ($navData as $data) {
                $rfq = RfqSubmission::find($data->id);
                $rfq->nav_status = $data->nav_status;
                $rfq->soap_data = $data->soap_data;
                $rfq->fault_code = $data->fault_code ?? null;
                $rfq->attempts = $rfq->attempts + 1;
                $rfq->save();
            }

            return true;
        }
        catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function purchaseQuote()
    {
        try {
            $rfqSubmission = RfqSubmission::with('items', 'vendorNumber')->where('status', 1)->where("nav_status", "!=", 'Success')->where("attempts", "<", 3)->get();
            $navData = [];
            if (count($rfqSubmission)) {
                foreach ($rfqSubmission as $value) {

                    $body = PurchaseQuoteService::xmlData($value, $value->items);

                    $url = "PurchaseQuote";
                    $headers = [
                        'Content-Type' => 'text/xml',
                        'SoapAction' => 'urn:microsoft-dynamics-schemas/page/purchasequote',
                    ];
                    $nav_response = $this->sendSoapRequest('POST', $url, $headers, $body);
                    $navRes = new stdClass();
                    $navRes->id = $value->id;
                    $navRes->soap_data = $body;
                    $navRes->fault_code = $nav_response->getData()->message;
                    $navRes->nav_status = $nav_response->getData()->status == 'Success' ? 'Success' : 'Failed';
                    array_push($navData, $navRes);
                }
            }
            foreach ($navData as $data) {

                $vendor = RfqSubmission::find($data->id);
                $vendor->nav_status = $data->nav_status;
                $vendor->soap_data = $data->soap_data;
                $vendor->fault_code = $data->fault_code;
                $vendor->attempts = $vendor->attempts + 1;
                $vendor->save();
            }
            return true;
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function updateAdminEmail(Request $request)
    {
        try {
            $user = Auth::user('admin');
            $a = Admin::where('email', $user->email)->first();
            if ($a) {
                $a->email = $request->email;
                $a->save();
                return $this->successResponse($a, "Admin email updated successfully");
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user('admin');
            if (isset($data['newPassword']) && !empty($data['newPassword'])) {
                $check = ($data['newPassword'] === $data['confirmNewPassword']);

                if ($check && isset($data['newPassword']) && !empty($data['newPassword'])) {
                    $admin = Admin::where('email', $user->email)->first();
                    $admin->password = Hash::make($data['newPassword']);
                    $admin->save();
                    return $this->successResponse($admin, "Admin password updated successfully");
                } else {
                    return $this->errorResponse('Password mismatched', 500);
                }
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    function updateUserPassword(UpdateUserPasswordRequest $request){
        try{
            $data = $request->all();
            $admin = Auth::user('admin');
            $user = User::where('registered_email_address', $data['registered_email_address'])->where('organization_id', $admin->organization_id)->first();

            if(!$user){
                throw new \Exception("User not found", 404);
            }else{
                $user->password = Hash::make($data['password']);
                $user->save();
                return $this->successResponse(null, "User password updated successfully");
            }
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
        }

    }
}
