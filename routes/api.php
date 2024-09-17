<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CPDController;
use App\Http\Controllers\API\SMSController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\LookupController;
use App\Http\Controllers\API\HrmisController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\ProviderController;
use App\Http\Controllers\API\LeaveRequestController;

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
$public_path = '/public';//Public API
$secure_path = '/secure';//Secure API (Require Token)

Route::post($public_path . '/signup', [AuthController::class, 'signup']);
Route::post($public_path . '/verify_otp', [AuthController::class, 'verifyOTP']);
Route::post($public_path . '/request_new_otp', [AuthController::class, 'requestNewOTP']);
Route::post($public_path . '/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post($secure_path . '/change-password', [AuthController::class, 'changePassword']);

Route::middleware('auth:sanctum')->get($secure_path . '/user', function (Request $request) {
    return $request->user();
});

/*----SMSController----*/
//Route::post($public_path . '/sendsms', [SMSController::class, 'sendSMS']);

//LookupController
Route::get($secure_path . '/get-ethnicities', [LookupController::class, 'getEthnicities']);
Route::get($secure_path . '/get-disabilities', [LookupController::class, 'getDisabilities']);
Route::get($secure_path . '/get-marital-status', [LookupController::class, 'getMaritalStatus']);

//CPDController
Route::get($public_path . '/cpd/search-box-cpd-activities', [CPDController::class, 'searchBoxCPDActivities']);
Route::post($public_path . '/cpd/search-cpd-activities', [CPDController::class, 'searchCPDActivities']);
Route::get($public_path . '/cpd/view-cpd-activity-details', [CPDController::class, 'viewCPDActivityDetails']);
Route::get($public_path . '/cpd/get-subjects-by-field/{field_id}', [CPDController::class, 'getSubjectsbyFieldId']);
Route::get($public_path . '/cpd/get-courses-by-subject/{subject_id}', [CPDController::class, 'getCoursesbySubjId']);
Route::middleware('auth:sanctum')->get($secure_path . '/cpd/view-own-cpd', [CPDController::class, 'viewOwnCPDList']);
Route::middleware('auth:sanctum')->get($secure_path . '/cpd/view-cpd-credits', [CPDController::class, 'viewCPDCredits']);
Route::middleware('auth:sanctum')->post($secure_path . '/cpd/signup-cpd', [CPDController::class, 'registerCPDActivity']);
Route::middleware('auth:sanctum')->get($secure_path . '/cpd/signout-cpd', [CPDController::class, 'unRegisterCPDActivity']);
Route::get($public_path . '/cpd/check-activity-status', [CPDController::class, 'checkActivityStatus']);

 // HrmisController
Route::get($secure_path.'/hrmis_staffs', [HrmisController::class, 'hrmis_staffs']);
Route::get($secure_path.'/hrmis_staffs_ii', [HrmisController::class, 'hrmis_staffs_ii']);
 Route::get($secure_path.'/cpd-providers', [HrmisController::class, 'cpd_provider_index']);
 Route::get($secure_path.'/cpd-field-of-studies', [HrmisController::class, 'cpd_field_of_studies_index']);
 Route::get($secure_path.'/cpd-subject-of-studies', [HrmisController::class, 'cpd_subject_of_studies_index']);
 Route::get($secure_path.'/cpd-courses', [HrmisController::class, 'cpd_courses_index']);
 Route::get($secure_path.'/cpd-schedule-courses', [HrmisController::class, 'cpd_schedule_courses_index']);
 Route::get($secure_path.'/cpd-credits-cpd-pendings', [HrmisController::class, 'cpd_credits_cpd_pendings_list']);
 Route::get($secure_path.'/cpd-credits-view-pendings', [HrmisController::class, 'cpd_credits_view_pending_cpd']);
 
 Route::get($secure_path.'/cpd-credits-staff-by-payroll-name', [HrmisController::class, 'cpd_credits_staff_by_payroll_name']);
 Route::get($secure_path.'/cpd-credits-staff-mobile-registrations', [HrmisController::class, 'cpd_credits_staff_mobile_registrations']);
 Route::get($secure_path.'/cpd-credits-view-cpd-credits', [HrmisController::class, 'cpd_credits_view_cpd_credits']);
 Route::get($secure_path.'/cpd-enrollment-courses', [HrmisController::class, 'cpd_enrollment_courses']);
 Route::get($secure_path.'/cpd-users', [HrmisController::class, 'cpd_users']);




/*----Provider's function-----*/
Route::middleware('auth:sanctum')->get($secure_path . '/cpd/provider-cpd', [CPDController::class, 'providerCPDList']);
Route::middleware('auth:sanctum')->get($secure_path . '/cpd/view-cpd-registrations', [CPDController::class, 'viewActivityRegistrations']);
Route::middleware('auth:sanctum')->post($secure_path . '/cpd/confirm-cpd-registrations', [CPDController::class, 'confirmActivityRegistrations']);
Route::middleware('auth:sanctum')->post($secure_path . '/cpd/reject-cpd-registration', [CPDController::class, 'rejectCPDRegistration']);
// Route::middleware('auth:sanctum')->post($secure_path . '/cpd/confirm-cpd-completion', [CPDController::class, 'confirmActivityCompletion']);


//StaffController
Route::get($secure_path . '/get-staff-profile', [StaffController::class, 'staffProfile']);
Route::get($secure_path . '/get-contract-profile', [StaffController::class, 'contractProfile']);
Route::get($secure_path . '/teaching-details', [StaffController::class, 'teachingDetails']);
Route::post($secure_path . '/add-comment-data', [StaffController::class, 'addCommentData']);
Route::get($secure_path . '/get-profile-pending', [StaffController::class, 'getProfilePending']);

//LeaveRequestController
Route::get($secure_path . '/leave-records-by-payroll', [LeaveRequestController::class, 'getShortLeavesByPayroll']);
Route::post($secure_path . '/store-leave-request', [LeaveRequestController::class, 'storeLeaveRequest']);
Route::post($secure_path . '/update-leave-request', [LeaveRequestController::class, 'updateLeaveRequest']);
Route::get($secure_path . '/delete-leave-request', [LeaveRequestController::class, 'destroyLeaveRequest']);

//ProviderController
Route::get($public_path . '/provider/get-providers', [ProviderController::class, 'getProviders']);
Route::get($public_path . '/provider/provider-details', [ProviderController::class, 'getProviderDetails']);

//LocationController
Route::get($public_path . '/locations/get-provinces', [LocationController::class, 'getProvinces']);
Route::get($public_path . '/locations/get-districts', [LocationController::class, 'getDistricts']);
Route::get($public_path . '/locations/get-communes', [LocationController::class, 'getCommunes']);
Route::get($public_path . '/locations/get-villages', [LocationController::class, 'getVillages']);
Route::get($public_path . '/locations/{location_name}/offices', [LocationController::class, 'getOfficeOfLocation']);
Route::get($public_path . '/locations/{location_name}/positions', [LocationController::class, 'getPositionOfLocation']);

require __DIR__ . '/api_share_v1.php';
