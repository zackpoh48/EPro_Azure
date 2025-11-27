<?php

namespace App\Services;

use App\Enum\StatusEnum;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Mailtrap;
use App\Models\Company;
use App\Models\Organization;
use App\Models\StatusLog;
use App\Models\UpdatedVendorProfile;
use App\Models\User;
use App\Services\BusinessCentral\BusinessCentralService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use stdClass;

class UserService
{
    private static function generateUsernameFromEmail($email)
    {
        // Remove everything after the '@' symbol
        $cleanedEmail = strtok($email, "@");

        // Extract the first three characters from the cleaned email
        $baseUsername = substr($cleanedEmail, 0, 3);

        // Maximum number of attempts
        $maxAttempts = 10;
        $attempt = 1;

        do {
            // Generate a unique suffix starting from 1001
            $suffix = 1000 + $attempt;
            $username = $baseUsername . $suffix;

            // Check if the username already exists
            $existingUser = User::where("username", $username)->exists();

            $attempt++;
        } while ($existingUser && $attempt <= $maxAttempts);

        // If the maximum attempts are reached and the username is still not unique, handle it here
        if ($existingUser) {
            // Handle the case where a unique username could not be generated within the maximum attempts
            throw new \Exception(
                "Unable to generate a unique username. Please try again later."
            );
        }

        return $username;
    }

    public static function store($userRequest, $organisation)
    {
        try {
            $response = new stdClass();
            $password = null;
            \DB::beginTransaction();

            $userEntity = User::where(
                "registered_email_address",
                $userRequest["registered_email_address"]
            )->first();
            $companyEntity = Company::where([
                "vendor_no" => $userRequest["vendor_no"],
                "organization_id" => $organisation->id,
            ])->first();

            if ($userEntity && $companyEntity) {
                if (
                    DB::table("user_companies")
                    ->where([
                        "user_id" => $userEntity->id,
                        "company_id" => $companyEntity->id,
                    ])
                    ->count()
                ) {
                    $response->message =
                        "User and company already exist and linked";
                } else {
                    $userEntity->companies()->attach([$companyEntity->id]);
                    $response->message =
                        "User and company already exist. User assigned to company.";
                }
            } elseif ($userEntity && !$companyEntity) {
                $companyEntity = self::createCompany(
                    $userRequest,
                    $organisation,
                    $userEntity
                );
                $userEntity->companies()->attach([$companyEntity->id]);
                $response->message = "Existing user assigned to new company.";
            } elseif (!$userEntity && $companyEntity) {
                $random = str_shuffle(
                    'abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'
                );
                $password = substr($random, 0, 10);
                $username = self::generateUsernameFromEmail(
                    $userRequest["registered_email_address"]
                );
                $userEntity = self::createUser(
                    $userRequest,
                    $organisation,
                    $password,
                    $username
                );

                $userEntity->companies()->attach([$companyEntity->id]);

                if ($organisation->send_registration_email) {
                    UserService::sendEmail(
                        $userEntity,
                        $password,
                        $companyEntity->vendor_no
                    );
                }
                $response->message =
                    "User created and assigned to existing company.";
            } else {
                $random = str_shuffle(
                    'abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'
                );
                $password = substr($random, 0, 10);
                $username = self::generateUsernameFromEmail(
                    $userRequest["registered_email_address"]
                );
                $userEntity = self::createUser(
                    $userRequest,
                    $organisation,
                    $password,
                    $username
                );

                $companyEntity = self::createCompany(
                    $userRequest,
                    $organisation,
                    $userEntity
                );

                $userEntity->companies()->attach([$companyEntity->id]);

                if ($organisation->send_registration_email) {
                    self::sendEmail(
                        $userEntity,
                        $password,
                        $userRequest["vendor_no"]
                    );
                }
                $response->message =
                    "Company and user created. User assigned to company.";
            }

            \DB::commit();
            $data = new stdClass();
            $data->name = $userEntity->name;
            $data->email = $userEntity->email;
            $data->registered_email_address =
                $userEntity->registered_email_address;
            if ($password != null) {
                $data->password = $password;
            }
            $data->username = $userEntity->username;
            $data->unique_id = $userEntity->unique_id;
            $data->organization_unique_id = $organisation->unique_id;
            $data->vendor_no = $companyEntity->vendor_no;
            $data->company_name = $companyEntity->company_name;
            $data->company_reg_no = $companyEntity->company_reg_no;
            $response->data = $data;
            return $response;
        } catch (\Exception $e) {
            \DB::rollback();
            dd($e);
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    private static function createUser(
        $userRequest,
        $organisation,
        $password,
        $username
    ): User {
        $uniqueId = Str::uuid();
        $userEntity = new User();
        $userEntity->name = htmlspecialchars($userRequest["name"]);
        // $userEntity->email = htmlspecialchars($userRequest["email"]);
        $userEntity->registered_email_address =
            htmlspecialchars($userRequest["registered_email_address"]) ?? null;
        $userEntity->password = Hash::make($password);
        $userEntity->unique_id = $uniqueId;
        $userEntity->organization_id = $organisation->id;
        $userEntity->username = $username;
        $userEntity->save();
        return $userEntity;
    }

    private static function createCompany(
        $userRequest,
        $organisation,
        $userEntity
    ): Company {
        $companyEntity = new Company();
        $companyEntity->vendor_no = htmlspecialchars($userRequest["vendor_no"]);
        $companyEntity->company_reg_no = htmlspecialchars(
            $userRequest["company_reg_no"]
        );
        $companyEntity->company_name = htmlspecialchars(
            $userRequest["company_name"]
        );
        $companyEntity->organization_id = $organisation->id;
        if (isset($userRequest["type"])) {
            $companyEntity->type = $userRequest["type"];
        }

        $createdBy = new stdClass();
        $createdBy->id = $userEntity->id;
        $createdBy->name = $userEntity->name;
        $createdBy->username = $userEntity->username;
        $createdBy->registered_email_address =
            $userEntity->registered_email_address;

        $companyEntity->created_by = json_encode($createdBy);
        $companyEntity->save();

        StatusLog::create([
            "reason" => null,
            "status" => StatusEnum::Draft,
            "user_id" => $userEntity->id,
            "company_id" => $companyEntity->id,
        ]);
        return $companyEntity;
    }

    // public static function update(
    //     UserUpdateRequest $userRequest,
    //     Company $company
    // ): void {
    //     try {
    //         \DB::beginTransaction();
    //         $userEntity = $userRequest->user();
    //         // $userEntity->email =
    //         //     htmlspecialchars($userRequest["email"]) ?? null;
    //         // $userEntity->save();
    //         // $userEntity->username =
    //         //     htmlspecialchars($userRequest["username"]) ?? null;
    //         // $userEntity->save();

    //         $company->registered_address_one =
    //             htmlspecialchars($userRequest["registered_address_one"]) ??
    //             null;
    //         $company->registered_address_two =
    //             htmlspecialchars($userRequest["registered_address_two"]) ??
    //             null;
    //         $company->mailing_address_one =
    //             htmlspecialchars($userRequest["mailing_address_one"]) ?? null;
    //         $company->mailing_address_two =
    //             htmlspecialchars($userRequest["mailing_address_two"]) ?? null;
    //         $company->city = htmlspecialchars($userRequest["city"]) ?? null;
    //         $company->state = htmlspecialchars($userRequest["state"]) ?? null;
    //         $company->zip_code =
    //             htmlspecialchars($userRequest["zip_code"]) ?? null;
    //         $company->country =
    //             htmlspecialchars($userRequest["country"]) ?? null;
    //         $company->tel_no = $userRequest["tel_no"] ?? null;
    //         $company->fax_no = htmlspecialchars($userRequest["fax_no"]) ?? null;
    //         $company->company_website =
    //             htmlspecialchars($userRequest["company_website"]) ?? null;
    //         $company->date_of_incorporation =
    //             $userRequest["date_of_incorporation"] != null
    //             ? date(
    //                 "Y-m-d",
    //                 strtotime(
    //                     str_replace(
    //                         ",",
    //                         " ",
    //                         $userRequest["date_of_incorporation"]
    //                     )
    //                 )
    //             )
    //             : null;

    //         $company->vendor_type =
    //             htmlspecialchars($userRequest["vendor_type"]) ?? null;
    //         $company->tin = htmlspecialchars($userRequest["tin"]) ?? null;
    //         $company->msic_code =
    //             htmlspecialchars($userRequest["msic_code"]) ?? null;
    //         $company->id_type =
    //             htmlspecialchars($userRequest["id_type"]) ?? null;
    //         $company->id_value =
    //             htmlspecialchars($userRequest["id_value"]) ?? null;

    //         $company->sst_registration_no =
    //             htmlspecialchars($userRequest["sst_registration_no"]) ?? null;
    //         $company->contact_person_one =
    //             htmlspecialchars($userRequest["contact_person_one"]) ?? null;
    //         $company->designation_one =
    //             htmlspecialchars($userRequest["designation_one"]) ?? null;
    //         $company->contact_person_two =
    //             htmlspecialchars($userRequest["contact_person_two"]) ?? null;
    //         $company->designation_two =
    //             htmlspecialchars($userRequest["designation_two"]) ?? null;
    //         $company->contact_person_three =
    //             htmlspecialchars($userRequest["contact_person_three"]) ?? null;
    //         $company->designation_three =
    //             htmlspecialchars($userRequest["designation_three"]) ?? null;
    //         $company->bank_name = $userRequest["bank_name"] ?? null;
    //         $company->bank_branch = $userRequest["bank_branch"] ?? null;
    //         $company->bank_account_no = $userRequest["bank_account_no"] ?? null;
    //         $company->swift_code = $userRequest["swift_code"] ?? null;
    //         $company->bank_address_one =
    //             htmlspecialchars($userRequest["bank_address_one"]) ?? null;
    //         $company->bank_address_two =
    //             htmlspecialchars($userRequest["bank_address_two"]) ?? null;

    //         if ($userRequest->hasfile("bank_statement")) {
    //             $bank_statement_attachments = "";
    //             foreach ($userRequest->file("bank_statement") as $file) {
    //                 $bankAttach =
    //                     $file->storeAs(
    //                         "public/" . $userEntity->unique_id,
    //                         $file->getClientOriginalName()
    //                     ) . ";";
    //                 $bankDoc = Storage::disk("local")->url($bankAttach);
    //                 $bank_statement_attachments .= $bankDoc;
    //             }
    //             $company->bank_statement_attachments = $bank_statement_attachments;
    //         }

    //         // $userEntity->product_desc_one =
    //         //     htmlspecialchars($userRequest["product_desc_one"]) ?? null;
    //         // $userEntity->product_desc_two =
    //         //     htmlspecialchars($userRequest["product_desc_two"]) ?? null;
    //         // $userEntity->product_desc_three =
    //         //     htmlspecialchars($userRequest["product_desc_three"]) ?? null;
    //         // $userEntity->product_desc_four =
    //         //     htmlspecialchars($userRequest["product_desc_four"]) ?? null;
    //         // $userEntity->product_desc_five =
    //         //     htmlspecialchars($userRequest["product_desc_five"]) ?? null;
    //         // $userEntity->product_desc_six =
    //         //     htmlspecialchars($userRequest["product_desc_six"]) ?? null;

    //         $company->type_of_company = $userRequest["type_of_company"];
    //         $company->type_of_company_other =
    //             htmlspecialchars($userRequest["type_of_company_other"]) ?? null;
    //         $company->credit_term_offered = $userRequest["credit_term_offered"];
    //         $company->credit_term_offered_other =
    //             htmlspecialchars($userRequest["credit_term_offered_other"]) ??
    //             null;
    //         // $userEntity->anti_bribery_acknowledgement =
    //         //     $userRequest["anti_bribery_acknowledgement"];

    //         // $userEntity->designation =
    //         //     htmlspecialchars($userRequest["designation"]) ?? null;
    //         // $userEntity->nric_no =
    //         //     htmlspecialchars($userRequest["nric_no"]) ?? null;
    //         // $userEntity->date =
    //         //     $userRequest["date"] != null
    //         //         ? date(
    //         //             "Y-m-d",
    //         //             strtotime(str_replace(",", " ", $userRequest["date"]))
    //         //         )
    //         //         : null;

    //         // $products = ["products_0", "products_1", "products_2"];
    //         // $product_catalogue = [
    //         //     "product_catalogue_0",
    //         //     "product_catalogue_1",
    //         //     "product_catalogue_2",
    //         // ];
    //         // $userEntity->product_files = "";
    //         // $userEntity->product_catalogue = "";

    //         if ($userRequest->hasfile("latest_business_registration")) {
    //             $latest_business_registration = "";
    //             foreach (
    //                 $userRequest->file("latest_business_registration")
    //                 as $file
    //             ) {
    //                 $profileAttach =
    //                     $file->storeAs(
    //                         "public/" . $userEntity->unique_id,
    //                         $file->getClientOriginalName()
    //                     ) . ";";
    //                 $profileDoc = Storage::disk("local")->url($profileAttach);
    //                 $latest_business_registration .= $profileDoc;
    //             }
    //             $company->latest_business_registration_files = $latest_business_registration;
    //         }

    //         if ($userRequest->hasfile("borang_p")) {
    //             $borang_p = "";
    //             foreach ($userRequest->file("borang_p") as $file) {
    //                 $profileAttach =
    //                     $file->storeAs(
    //                         "public/" . $userEntity->unique_id,
    //                         $file->getClientOriginalName()
    //                     ) . ";";
    //                 $profileDoc = Storage::disk("local")->url($profileAttach);
    //                 $borang_p .= $profileDoc;
    //             }
    //             $company->borang_p_files = $borang_p;
    //         }

    //         if ($userRequest->hasfile("form_49")) {
    //             $form_49 = "";
    //             foreach ($userRequest->file("form_49") as $file) {
    //                 $profileAttach =
    //                     $file->storeAs(
    //                         "public/" . $userEntity->unique_id,
    //                         $file->getClientOriginalName()
    //                     ) . ";";
    //                 $profileDoc = Storage::disk("local")->url($profileAttach);
    //                 $form_49 .= $profileDoc;
    //             }
    //             $company->form_49_files = $form_49;
    //         }

    //         if ($userRequest->hasfile("photocopy_ic")) {
    //             $photocopy_ic = "";
    //             foreach ($userRequest->file("photocopy_ic") as $file) {
    //                 $profileAttach =
    //                     $file->storeAs(
    //                         "public/" . $userEntity->unique_id,
    //                         $file->getClientOriginalName()
    //                     ) . ";";
    //                 $profileDoc = Storage::disk("local")->url($profileAttach);
    //                 $photocopy_ic .= $profileDoc;
    //             }
    //             $company->photocopy_ic_files = $photocopy_ic;
    //         }

    //         // foreach ($products as $product) {
    //         //     if (isset($userRequest[$product])) {
    //         //         $prodAttach =
    //         //             $userRequest[$product]->storeAs(
    //         //                 "public/" . $userEntity->unique_id,
    //         //                 $userRequest[$product]->getClientOriginalName()
    //         //             ) . ";";
    //         //         $prodDocs = Storage::disk("local")->url($prodAttach);
    //         //         $userEntity->product_files .= $prodDocs;
    //         //     }
    //         // }
    //         // foreach ($product_catalogue as $catalogue) {
    //         //     if (isset($userRequest[$catalogue])) {
    //         //         $prodAttach =
    //         //             $userRequest[$catalogue]->storeAs(
    //         //                 "public/" . $userEntity->unique_id,
    //         //                 $userRequest[$catalogue]->getClientOriginalName()
    //         //             ) . ";";
    //         //         $prodDocs = Storage::disk("local")->url($prodAttach);
    //         //         $userEntity->product_catalogue .= $prodDocs;
    //         //     }
    //         // }

    //         $company->is_print = 0;
    //         // $userEntity->is_print_upload = 0;
    //         $company->is_complete = 0;
    //         $company->save();
    //         \DB::commit();
    //     } catch (\Exception $e) {
    //         dd($e);
    //         \DB::rollback();
    //         throw new \Exception(
    //             $e->getMessage(),
    //             $e->getCode() ? $e->getCode() : 500
    //         );
    //     }
    // }

    public static function update(UserUpdateRequest $userRequest, Company $company)
    {
        try {
            DB::beginTransaction();

            $user = $userRequest->user();
            
            $payload = [
                "number"                            => $company->vendor_no,   
                "webPortalLoginId"                  => $userRequest->email ?? "",
                "email"                             => $userRequest->email ?? "",
                "contact"                           => $userRequest->contact_person_one ?? "",
                "name"                              => $userRequest->company_name ?? "",
                "name2"                             => "",
                
                "registeredAddress"                 => $userRequest->registered_address_one ?? "",
                "registeredAddress2"                => $userRequest->registered_address_two ?? "",
                // "registeredCity"                    => $userRequest->city ?? "",
                // "registeredState"                   => $userRequest->state ?? "",
                // "registeredCountry"                 => $userRequest->country ?? "",
                // "registeredPostCode"                => $userRequest->zip_code ?? "",

                // "mailingAddressSameAsRegisteredAddress" => false,
                "mailingAddress"                    => $userRequest->mailing_address_one ?? "",
                "mailingAddress2"                   => $userRequest->mailing_address_two ?? "",
                "mailingCity"                       => $userRequest->mailing_city ?? "",
                "mailingState"                      => $userRequest->mailing_state ?? "",
                "mailingPostCode"                   => $userRequest->mailing_post_code ?? "",
                "mailingCountry"                    => $userRequest->mailing_country ?? "",

                "phoneNo"                           => $userRequest->tel_no ?? "",
                "faxNo"                             => $userRequest->fax_no ?? "",
                "homePage"                          => $userRequest->company_website ?? "",

                "typeOfIncorporation"               => $userRequest->type_of_company ?? "",
                "typeOfIncorporationOthers"         => $userRequest->type_of_company_other ?? "",
                "dateIncorporated"                  => $userRequest->date_of_incorporation ? \Carbon\Carbon::parse($userRequest->date_of_incorporation)->format('Y-m-d') : "",
                
                // "vendorType"                        => $userRequest->vendor_type ?? "",
                "companyRegNo"                      => $company->company_reg_no ?? "",
                "vatRegistrationNo"                 => $userRequest->sst_registration_no ?? "",
                // "tin"                               => $userRequest->tin ?? "",
                // "idType"                            => $userRequest->id_type ?? "",
                // "idValue"                           => $userRequest->id_value ?? "",
                // "accountType"                       => $userRequest->account_type ?? "",

                // "msicCode"                          => $userRequest->msic_code ?? "",

                "contactName1"                      => $userRequest->contact_person_one ?? "",
                "designation1"                      => $userRequest->designation_one ?? "",
                "contactName2"                      => $userRequest->contact_person_two ?? "-",
                "designation2"                      => $userRequest->designation_two ?? "-",
                "contactName3"                      => $userRequest->contact_person_three ?? "-",
                "designation3"                      => $userRequest->designation_three ?? "-",

                // "annualTurnover"                    => $userRequest->annual_turnover ?? "",
                // "workingCapital"                    => $userRequest->working_capital ?? "",
                // "netWorth"                          => $userRequest->net_worth ?? "",
                // "cashBankBalance"                   => $userRequest->cash_bank_balance ?? "",
                // "paidUpCapital"                     => $userRequest->paid_up_capital ?? "",

                // "productDescription1"               => $userRequest->product_desc_one ?? "",
                // "productDescription2"               => $userRequest->product_desc_two ?? "",
                // "productDescription3"               => $userRequest->product_desc_three ?? "",
                // "productDescription4"               => $userRequest->product_desc_four ?? "",
                // "productDescription5"               => $userRequest->product_desc_five ?? "",
                // "productDescription6"               => $userRequest->product_desc_six ?? "",

                "creditTerms"                       => $userRequest->credit_term_offered ?? "",
                "creditTermsOthers"                 => $userRequest->credit_term_offered_other ?? "",

                // "iSO9001"                           => (bool) $userRequest->iso_9001,
                // "iSO14001"                          => (bool) $userRequest->iso_14001,
                // "oHSAS18001"                        => (bool) $userRequest->ohsas_18001,
                // "iSO37001"                          => (bool) $userRequest->iso_37001,
                // "certificationOthers"               => (bool) $userRequest->certification_others,
                // "certificationPleaseSpecify"        => $userRequest->certification_specify ?? "",

                // "litigationRecords"                 => (bool) $userRequest->litigation_records,
                // "litigationRecordsDesc"             => $userRequest->litigation_records_desc ?? "",
                // "corruptionFraudulent"              => (bool) $userRequest->corruption_fraudulent,
                // "corruptionFraudulentDesc"          => $userRequest->corruption_fraudulent_desc ?? "",

                "businessRegistrationForm"          => $company->latest_business_registration_files ?? "",
                "borangP"                           => $company->borang_p_files ?? "",
                "form49"                            => $company->form_49_files ?? "",
                "ic"                                => $company->photocopy_ic_files ?? "",
                "bankStatement"                     => $company->bank_statement_attachments ?? "",
                // "vlod"                              => "",

                "bankName"                          => $userRequest->bank_name ?? "",
                "bankBranch"                        => $userRequest->bank_branch ?? "",
                "swiftCode"                         => $userRequest->swift_code ?? "",
                "bankAccountNo"                     => $userRequest->bank_account_no ?? "",
                "bankAddress"                       => $userRequest->bank_address_one ?? "",
                "bankAddress2"                      => $userRequest->bank_address_two ?? "",
            ];

            $bcResponse = app(BusinessCentralService::class)
                ->updateVendorProfile($company->company_reg_no, json_encode($payload));
            $company->is_print = 0;
            $company->is_complete = 0;
            $company->save();

            DB::commit();

            if (isset($bcResponse->number) && $bcResponse->number === $company->vendor_no) {
                return $bcResponse;
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function printPdf(Company $company)
    {
        try {
            if ($company) {
                $company->is_print = 1;
                $company->is_complete = 1;
                $company->save();
                return url("/assets/Vendor-Letter-of-Declaration.pdf");
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    // public static function uploadPdf(Request $request)
    // {
    //     try {
    //         $user = $request->user();
    //         if ($user) {
    //             $pdfFile = $request->file("file");
    //             $pdfFileName = $pdfFile->getClientOriginalName();
    //             $pdfDocs = $pdfFile->storeAs(
    //                 "public/" . $user->unique_id,
    //                 $pdfFileName
    //             );
    //             $getPdfFile = Storage::disk("local")->url($pdfDocs);
    //             $user->supplier_pdf = $getPdfFile;
    //             // $user->is_print_upload = 1;
    //             $user->save();
    //             return $user;
    //         }
    //     } catch (\Exception $e) {
    //         throw new \Exception(
    //             $e->getMessage(),
    //             $e->getCode() ? $e->getCode() : 500
    //         );
    //     }
    // }

    public static function finalSubmit(Company $company, User $user)
    {
        try {
            if ($company->is_print == 1 && $company->is_complete == 1) {
                $company->status = StatusEnum::Submitted;
                $company->completed_at = Carbon::now();
                $company->save();
                self::sendEmailToAdmin($company, $user);
                StatusLog::create([
                    "reason" => null,
                    "status" => StatusEnum::Submitted,
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ]);
                return $company;
            }
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function sendEmail(User $user, $password, $vendor_no): void
    {
        try {
            $details = [
                "name" => $user->name,
                "username" => $user->username,
                "vendor_no" => $vendor_no,
                "password" => $password,
                "template" => "mail.registration-email",
                "subject" => "Registration",
            ];

            Mail::to($user->registered_email_address)->send(
                new Mailtrap($details)
            );
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function sendEmailToAdmin($company, $user): void
    {
        try {
            $token = Str::random(60);

            DB::table("status_change_tokens")->updateOrInsert(
                [
                    "user_id" => $user->id,
                    "company_id" => $company->id,
                ],
                ["token" => $token, "created_at" => Carbon::now()]
            );

            $details = [
                "name" => $user->name,
                "username" => $user->username,
                "company_name" => $company->company_name,
                "address" =>
                $company->registered_address_one .
                    " " .
                    $company->registered_address_two,
                "vendor_no" => $company->vendor_no,
                "template" => "mail.review-email",
                "subject" =>
                "New Vendor Registration Details for Review - Vendor No: " .
                    $company->vendor_no .
                    " - Company: " .
                    $company->company_name,
                "unique_id" => $token,
            ];

            Mail::to(env("ADMIN_EMAIL_ADDRESS"))->send(new Mailtrap($details));
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function updateStatus($status, $token)
    {
        try {
            Db::beginTransaction();
            $updateStatus = DB::table("status_change_tokens")
                ->where([
                    "token" => $token,
                ])
                ->first();

            if (!$updateStatus) {
                throw new \Exception("Failed, Status already updated.", 400);
            }

            $company = Company::findOrFail($updateStatus->company_id);

            $company->status = $status;
            if ($company->status == StatusEnum::Rejected->value) {
                $company->is_print = 0;
                // $company->is_print_upload = 0;
                $company->is_complete = 0;
            }
            $company->save();

            $user = User::findOrFail($updateStatus->user_id);

            DB::table("status_change_tokens")
                ->where([
                    "token" => $token,
                ])
                ->delete();

            StatusLog::create([
                "reason" => null,
                "status" => $status,
                "user_id" => $user->id,
                "company_id" => $company->id,
            ]);

            if (
                Organization::find($company->organization_id)->first()
                ->send_registration_email
            ) {
                self::sendEmailToNotifyUser($user, $company);
            }
            Db::commit();
            return ["status" => $status];
        } catch (\Exception $e) {
            Db::rollBack();
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function sendEmailToNotifyUser(
        User $user,
        Company $company
    ): void {
        try {
            $template = "mail.resubmission-email";
            if ($company->status == StatusEnum::Approved->value) {
                $template = "mail.confirmation-email";
            } elseif ($company->status == StatusEnum::Rejected->value) {
                $template = "mail.rejection-email";
            }

            $details = [
                "name" => $user->name,
                "username" => $user->username,
                "company_name" => $company->company_name,
                "address" =>
                $company->registered_address_one .
                    " " .
                    $company->registered_address_two,
                "vendor_no" => $company->vendor_no,
                "template" => $template,
                "subject" =>
                "Vendor Registration Review Response - Vendor No: " .
                    $company->vendor_no .
                    " - Company: " .
                    $company->company_name,
            ];

            Mail::to($user->registered_email_address)->send(
                new Mailtrap($details)
            );
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getFileURL(Request $request)
    {
        try {
            $user_organization = Organization::find(
                $request->user()->organization_id
            )->first();

            return asset($user_organization->terms_and_condition_file);
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function updateVendorProfile(
        Request $vendorUpdateRequest,
        Company $company
    ): void {
        try {
            \DB::beginTransaction();
            $vendor = $vendorUpdateRequest->user();

            $vendorProfileEntity = new UpdatedVendorProfile();
            $vendorProfileEntity->user_id = $vendor->id;
            $vendorProfileEntity->company_id = $company->id;
            $vendorProfileEntity->organization_id = $company->organization_id;
            $vendorProfileEntity->name = $vendor->name;
            $vendorProfileEntity->username = $vendor->username;
            $vendorProfileEntity->registered_email_address =
                $vendor->registered_email_address;
            $vendorProfileEntity->vendor_no = $company->vendor_no;
            $vendorProfileEntity->company_name = $company->company_name;
            $vendorProfileEntity->company_reg_no = $company->company_reg_no;
            $vendorProfileEntity->nav_status = "created";
            $vendorProfileEntity->attempts = 0;

            $vendorProfileEntity->registered_address_one =
                htmlspecialchars(
                    $vendorUpdateRequest["registered_address_one"]
                ) ?? null;
            $vendorProfileEntity->registered_address_two =
                htmlspecialchars(
                    $vendorUpdateRequest["registered_address_two"]
                ) ?? null;
            $vendorProfileEntity->mailing_address_one =
                htmlspecialchars($vendorUpdateRequest["mailing_address_one"]) ??
                null;
            $vendorProfileEntity->mailing_address_two =
                htmlspecialchars($vendorUpdateRequest["mailing_address_two"]) ??
                null;
            $vendorProfileEntity->city =
                htmlspecialchars($vendorUpdateRequest["city"]) ?? null;
            $vendorProfileEntity->state =
                htmlspecialchars($vendorUpdateRequest["state"]) ?? null;
            $vendorProfileEntity->zip_code =
                htmlspecialchars($vendorUpdateRequest["zip_code"]) ?? null;
            $vendorProfileEntity->country =
                htmlspecialchars($vendorUpdateRequest["country"]) ?? null;
            $vendorProfileEntity->tel_no =
                $vendorUpdateRequest["tel_no"] ?? null;
            $vendorProfileEntity->fax_no =
                htmlspecialchars($vendorUpdateRequest["fax_no"]) ?? null;
            $vendorProfileEntity->company_website =
                htmlspecialchars($vendorUpdateRequest["company_website"]) ??
                null;
            $vendorProfileEntity->date_of_incorporation =
                $vendorUpdateRequest["date_of_incorporation"] != null
                ? date(
                    "Y-m-d",
                    strtotime(
                        str_replace(
                            ",",
                            " ",
                            $vendorUpdateRequest["date_of_incorporation"]
                        )
                    )
                )
                : null;
            $vendorProfileEntity->sst_registration_no =
                htmlspecialchars($vendorUpdateRequest["sst_registration_no"]) ??
                null;
            $vendorProfileEntity->contact_person_one =
                htmlspecialchars($vendorUpdateRequest["contact_person_one"]) ??
                null;
            $vendorProfileEntity->designation_one =
                htmlspecialchars($vendorUpdateRequest["designation_one"]) ??
                null;
            $vendorProfileEntity->contact_person_two =
                htmlspecialchars($vendorUpdateRequest["contact_person_two"]) ??
                null;
            $vendorProfileEntity->designation_two =
                htmlspecialchars($vendorUpdateRequest["designation_two"]) ??
                null;
            $vendorProfileEntity->contact_person_three =
                htmlspecialchars(
                    $vendorUpdateRequest["contact_person_three"]
                ) ?? null;
            $vendorProfileEntity->designation_three =
                htmlspecialchars($vendorUpdateRequest["designation_three"]) ??
                null;
            $vendorProfileEntity->bank_name =
                $vendorUpdateRequest["bank_name"] ?? null;
            $vendorProfileEntity->bank_branch =
                $vendorUpdateRequest["bank_branch"] ?? null;
            $vendorProfileEntity->bank_account_no =
                $vendorUpdateRequest["bank_account_no"] ?? null;
            $vendorProfileEntity->swift_code =
                $vendorUpdateRequest["swift_code"] ?? null;
            $vendorProfileEntity->bank_address_one =
                htmlspecialchars($vendorUpdateRequest["bank_address_one"]) ??
                null;
            $vendorProfileEntity->bank_address_two =
                htmlspecialchars($vendorUpdateRequest["bank_address_two"]) ??
                null;

            if ($vendorUpdateRequest->hasfile("bank_statement")) {
                $bank_statement_attachments = "";
                foreach (
                    $vendorUpdateRequest->file("bank_statement")
                    as $file
                ) {
                    $bankAttach =
                        $file->storeAs(
                            "public/" . $vendorProfileEntity->unique_id,
                            $file->getClientOriginalName()
                        ) . ";";
                    $bankDoc = Storage::disk("local")->url($bankAttach);
                    $bank_statement_attachments .= $bankDoc;
                }
                $vendorProfileEntity->bank_statement_attachments = $bank_statement_attachments;
            }

            $vendorProfileEntity->type_of_company =
                $vendorUpdateRequest["type_of_company"];
            $vendorProfileEntity->type_of_company_other =
                htmlspecialchars(
                    $vendorUpdateRequest["type_of_company_other"]
                ) ?? null;
            $vendorProfileEntity->credit_term_offered =
                $vendorUpdateRequest["credit_term_offered"];
            $vendorProfileEntity->credit_term_offered_other =
                htmlspecialchars(
                    $vendorUpdateRequest["credit_term_offered_other"]
                ) ?? null;

            if ($vendorUpdateRequest->hasfile("latest_business_registration")) {
                $latest_business_registration = "";
                foreach (
                    $vendorUpdateRequest->file("latest_business_registration")
                    as $file
                ) {
                    $profileAttach =
                        $file->storeAs(
                            "public/" . $vendorProfileEntity->unique_id,
                            $file->getClientOriginalName()
                        ) . ";";
                    $profileDoc = Storage::disk("local")->url($profileAttach);
                    $latest_business_registration .= $profileDoc;
                }
                $vendorProfileEntity->latest_business_registration_files = $latest_business_registration;
            }

            if ($vendorUpdateRequest->hasfile("borang_p")) {
                $borang_p = "";
                foreach ($vendorUpdateRequest->file("borang_p") as $file) {
                    $profileAttach =
                        $file->storeAs(
                            "public/" . $vendorProfileEntity->unique_id,
                            $file->getClientOriginalName()
                        ) . ";";
                    $profileDoc = Storage::disk("local")->url($profileAttach);
                    $borang_p .= $profileDoc;
                }
                $vendorProfileEntity->borang_p_files = $borang_p;
            }

            if ($vendorUpdateRequest->hasfile("form_49")) {
                $form_49 = "";
                foreach ($vendorUpdateRequest->file("form_49") as $file) {
                    $profileAttach =
                        $file->storeAs(
                            "public/" . $vendorProfileEntity->unique_id,
                            $file->getClientOriginalName()
                        ) . ";";
                    $profileDoc = Storage::disk("local")->url($profileAttach);
                    $form_49 .= $profileDoc;
                }
                $vendorProfileEntity->form_49_files = $form_49;
            }

            if ($vendorUpdateRequest->hasfile("photocopy_ic")) {
                $photocopy_ic = "";
                foreach ($vendorUpdateRequest->file("photocopy_ic") as $file) {
                    $profileAttach =
                        $file->storeAs(
                            "public/" . $vendorProfileEntity->unique_id,
                            $file->getClientOriginalName()
                        ) . ";";
                    $profileDoc = Storage::disk("local")->url($profileAttach);
                    $photocopy_ic .= $profileDoc;
                }
                $vendorProfileEntity->photocopy_ic_files = $photocopy_ic;
            }

            $vendorProfileEntity->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }

    public static function getCompanies(User $user)
    {
        try {
            $userCompanies = $user->companies;
            $companies = [];
            $organizationMap = [];
            if (count($userCompanies)) {
                foreach ($userCompanies as $userCompany) {
                    $company = new stdClass();
                    $company->company_name = $userCompany->company_name;
                    $company->vendor_no = $userCompany->vendor_no;
                    $company->company_reg_no = $userCompany->company_reg_no;
                    $company->status = $userCompany->status;
                    $company->id = $userCompany->id;
                    $company->unique_id = $user->unique_id;
                    if (
                        array_key_exists(
                            $userCompany->organization_id,
                            $organizationMap
                        )
                    ) {
                        $organization =
                            $organizationMap[$userCompany->organization_id];
                    } else {
                        $organization = Organization::find(
                            $userCompany->organization_id
                        );
                        if (!$organization) {
                            throw new \Exception("Organization not found", 404);
                        }
                        $organizationMap[$organization->id] = $organization;
                    }
                    $company->organization_name = $organization->name;
                    array_push($companies, $company);
                }
            }

            return $companies;
        } catch (\Exception $e) {
            throw new \Exception(
                $e->getMessage(),
                $e->getCode() ? $e->getCode() : 500
            );
        }
    }
}
