<?php

use Illuminate\Support\Facades\Route;
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
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('v1/login', [V1LoginController::class, 'login'])->name('v1-login');
Route::post('v1/admin-login', [V1LoginController::class, 'adminLogin']);

Route::post('v1/reset-password', [V1LoginController::class, 'sendPasswordResetLink']);
Route::post('v1/reset/password', [V1ResetPasswordController::class, 'callResetPassword']);

Route::post('v1/register', [V1SupplierController::class, 'store']);
Route::post('v1/passcode-verify', [V1SupplierController::class, 'passcodeVerification']);
Route::get('get-supplier-details', [V1SupplierController::class, 'getSupplierDetails']);
Route::get('print-pdf/{unique_id}', [V1SupplierController::class, 'printPdf']);
Route::post('v1/upload-pdf', [V1SupplierController::class, 'uploadPdf']);
Route::post('v1/final-submit', [V1SupplierController::class, 'finalSubmit']);

Route::group(['middleware' => 'apiCheck'], function () {
    Route::post('v1/rfq-create', [V1RfqController::class, 'store']);
    Route::post('v1/invite-vendor', [V1VendorInviteController::class, 'inviteVendor']);
    Route::post('v1/rfq-invite', [V1RfqInviteController::class, 'inviteMultipleRfq']);
});

// Route::post('v1/rfq-active-inactive', [V1RfqController::class, 'RfqDeactivate'])->middleware('apiCheck');

Route::post('v1/update-password', [V1RfqInviteController::class, 'updatePassword']);
Route::get('get-logo', [V1AdminController::class, 'getCompanyLogo']);

Route::group(['middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    Route::post('v1/admin-logout', [V1LoginController::class, 'adminLogout']);
    Route::post('v1/import', [V1AdminController::class, 'import']);
    Route::post('v1/settings', [V1AdminController::class, 'updateSettings']);
    Route::get('settings', [V1AdminController::class, 'getSettings']);
    Route::post('v1/generate-api-token', [V1AdminController::class, 'getApiToken']);
    Route::post('v1/update-company-logo', [V1AdminController::class, 'updateCompanyLogo']);

    Route::post('v1/deactivate-vendor', [V1RfqInviteController::class, 'deactivateVendor']);
    Route::post('v1/deactivate-rfqvendor', [V1RfqInviteController::class, 'deactivateRfqVendor']);
    Route::post('v1/update-admin-email', [V1AdminController::class, 'updateAdminEmail']);
    Route::get('get-admin-name', [V1AdminController::class, 'getAdminName']);
    Route::post('v1/admin-change-password', [V1AdminController::class, 'changePassword']);
});
Route::group(['middleware' => ['auth:rfq_invite', 'scopes:supplier']], function () {
    Route::post('v1/logout', [V1LoginController::class, 'logout']);
    Route::get('rfq-details', [V1RfqController::class, 'getRfqDetails']);
    Route::get('rfq-list', [V1RfqController::class, 'getRfqList']);
    Route::post('v1/update-rfq-details', [V1RfqSubmissionController::class, 'updateRfqDetails']);
});
