<?php

use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchaseQuoteController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| V1 API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\v1\LoginController as V1LoginController;
use App\Http\Controllers\v1\AdminController as V1AdminController;
use App\Http\Controllers\v1\RfqController as V1RfqController;
use App\Http\Controllers\v1\RfqSubmissionController as V1RfqSubmissionController;
use App\Http\Controllers\v1\RfqInviteController as V1RfqInviteController;
use App\Http\Controllers\v1\VendorInviteController as V1VendorInviteController;
use App\Http\Controllers\v1\SupplierController as V1SupplierController;
use App\Http\Controllers\v1\ResetPasswordController as V1ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("login", [LoginController::class, "login"]);
Route::post("admin-login", [LoginController::class, "adminLogin"]);

Route::post("reset-password", [
    LoginController::class,
    "sendPasswordResetLink",
]);
Route::post("reset/password", [
    ResetPasswordController::class,
    "callResetPassword",
]);

// Route::get("users/{uuid}/profile-details", [UserController::class, "show"]);

// Route::post("users/{uuid}/profile-details", [
//     UserController::class,
//     "updateProfile",
// ]);

Route::post("users/{token}/status/{status}", [
    UserController::class,
    "updateStatus",
]);

Route::get('/update-company-status', [AdminController::class, 'updateCompanyStatusViaEncodedLink']);

Route::get("countries/{country:name}/states", [
    AdminController::class,
    "getStates",
]);
Route::get("countries", [AdminController::class, "getCountries"]);
Route::get("countryCodes", [AdminController::class, "getCountryCodes"]);
Route::get("msicCodes", [AdminController::class, "getMsicCodes"]);

Route::get("countries-list", [AdminController::class, 'getAllCountries']);
Route::get("msic-list", [AdminController::class, 'getAllMsicCodes']);
Route::get("state-list", [AdminController::class, 'getAllStates']);

// organisation
Route::post("organizations/{organization_id?}", [
    AdminController::class,
    "store",
])->middleware("basicAuth");

Route::group(
    ["middleware" => ["auth:api", "isActivated", "scopes:user"]],
    function () {
        Route::post("users/companies/{company_id}", [
            UserController::class,
            "update",
        ]);
        Route::get("users/companies/{vendor_no}", [
            UserController::class,
            "show",
        ]);
        Route::get("users/companies/{company_id}/print-pdf", [
            UserController::class,
            "printPdf",
        ]);
        // Route::post("users/upload-pdf", [UserController::class, "uploadPdf"]);
        Route::post("users/companies/{company_id}/final-submit", [
            UserController::class,
            "finalSubmit",
        ]);
        Route::get("terms-and-condition-url", [
            UserController::class,
            "getFileURL",
        ]);

        Route::get("users/companies", [UserController::class, "getCompanies"]);

        Route::get("user/rfq-list", [V1RfqController::class, "getRfqList"]);
        Route::get("user/rfq-details", [
            V1RfqController::class,
            "getRfqDetails",
        ]);
        Route::post("user/update-rfq-details", [
            V1RfqSubmissionController::class,
            "updateRfqDetails",
        ]);

        Route::post("user/create-sub-purchase-quote-lines",[
            V1RfqSubmissionController::class,
            "createSubPurchaseQuoteLines",
        ]);

        Route::post("logout", [LoginController::class, "logout"]);

        Route::post("users/update-password", [
            ResetPasswordController::class,
            "callUpdatePassword",
        ]);

        // Route::get("users/purchase-invoices/{invoice_number?}", [
        //     PurchaseInvoiceController::class,
        //     "getPurchaseInvoices",
        // ]);

        Route::get("users/companies/{company}/vendor-statements", [
            StatementController::class,
            "getVendorStatements",
        ]);
        Route::get("users/companies/{company}/vendor-statements/export", [
            StatementController::class,
            "getVendorStatementsExport",
        ]);

        Route::get(
            "users/companies/{company}/purchase-orders/{order_number?}",
            [DeliveryOrderController::class, "getPurchaseOrders"]
        );

        Route::get(
            "users/companies/{company_id}/delivery-orders/{purchase_order_no}",
            [DeliveryOrderController::class, "show"]
        );

        Route::delete(
            "users/companies/{company_id}/delivery-orders/{purchase_order_no}",
            [DeliveryOrderController::class, "delete"]
        );

        Route::post(
            "users/companies/{company_id}/delivery-orders/{purchase_order_no}",
            [DeliveryOrderController::class, "store"]
        );

        // Route::get("users/credit-memo", [
        //     CreditMemoController::class,
        //     "getCreditMemo",
        // ]);

        Route::post("users/companies/{company_id}/vendor-profiles", [
            UserController::class,
            "updateVendorProfile",
        ]);

        Route::get(
            "users/companies/{company}/purchase-quotes/{quote_number?}/{vendor_no?}",
            [PurchaseQuoteController::class, "getPurchaseQuotes"]
        );

        Route::get("users/companies/{company}/{vendor_no}/purchase-quotes", [PurchaseQuoteController::class, "getPurchaseQuotesbyVendor"]);

        Route::get("users/companies/{company_id}/quotes", [
            PurchaseQuoteController::class,
            "show",
        ]);

        Route::delete("users/companies/{company_id}/purchase-quotes", [
            PurchaseQuoteController::class,
            "delete",
        ]);

        Route::post("users/companies/{company_id}/purchase-quotes", [
            PurchaseQuoteController::class,
            "store",
        ]);
    }
);

Route::group(["middleware" => ["auth:admin-api", "scopes:admin"]], function () {
    Route::post("admin-logout", [LoginController::class, "adminLogout"]);
    Route::post("generate-api-token", [AdminController::class, "getApiToken"]);
    Route::get("admin-name", function (Request $request) {
        return ["data" => $request->user()];
    });
});

Route::middleware("apiCheck")->group(function () {
    Route::post("users/{uuid}/change-status", [
        AdminController::class,
        "updateUser",
    ]);
    Route::delete("{organization_id}/deregister", [
        AdminController::class,
        "unAssignCompany",
    ]);
    Route::post("{organization_id}/vendors/{vendor_no}", [
        AdminController::class,
        "updateCompanyStatus",
    ]);

    Route::post("{organization_id}/register", [
        UserController::class,
        "store",
    ])->middleware("log");
});

Route::post("registration", [V1SupplierController::class, "store"]);
Route::post("passcode-verify", [
    V1SupplierController::class,
    "passcodeVerification",
]);
Route::get("get-supplier-details", [
    V1SupplierController::class,
    "getSupplierDetails",
]);
Route::put("update-disclosure-agreement", [
    V1SupplierController::class,
    "updateDisclosureAgreement",
]);
Route::get("print-pdf/{unique_id}", [V1SupplierController::class, "printPdf"]);
Route::post("upload-pdf", [V1SupplierController::class, "uploadPdf"]);
Route::post("final-submit", [V1SupplierController::class, "finalSubmit"]);

Route::group(["middleware" => "apiCheck"], function () {
    Route::post("invite-vendor", [
        V1VendorInviteController::class,
        "inviteVendor",
    ]);
});

Route::get("get-logo", [V1AdminController::class, "getCompanyLogo"]);
Route::get("get-organization-logo/{organization_id}", [
    V1AdminController::class,
    "getOrganizationLogo",
]);

Route::post("admin-create", [V1AdminController::class, "create"])->middleware(
    "basicAuth"
);

Route::group(["middleware" => ["auth:admin-api", "scopes:admin"]], function () {
    Route::post("import", [V1AdminController::class, "import"]);
    Route::post("settings", [V1AdminController::class, "updateSettings"]);
    Route::get("settings", [V1AdminController::class, "getSettings"]);
    Route::post("update-company-logo", [
        V1AdminController::class,
        "updateCompanyLogo",
    ]);
    Route::post("update-admin-email", [
        V1AdminController::class,
        "updateAdminEmail",
    ]);
    Route::get("get-admin-name", [V1AdminController::class, "getAdminName"]);
    Route::post("admin-change-password", [
        V1AdminController::class,
        "changePassword",
    ]);

    Route::post("rfq-create", [V1RfqController::class, "store"]);
    Route::get("admin-rfq-list", [V1AdminController::class, "getAdminRfqList"]);
    Route::get("admin-rfq-users", [
        V1AdminController::class,
        "getAdminRfqUsers",
    ]);
    Route::post("admin-rfq-submit", [
        V1AdminController::class,
        "submitRfqInvite",
    ]);

    Route::post("update-user-password", [
        V1AdminController::class,
        "updateUserPassword",
    ]);
});
