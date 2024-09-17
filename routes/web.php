<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffApprovalController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MultiCriteriaSearchController;
use App\Http\Controllers\Reports\StaffTransferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Staff;
use App\Models\WorkHistory;
use App\Models\User;
use App\Models\Profile\ProfileCheck;
use App\Models\StaffLeave;

View::composer('*', function ($view) {
    $countUsersNeedApproval = 0;
    $countUsersNeedApprovalpoe = 0;
    $countStaffsNeedApproval = 0;
    $countCPDNeedApproval = 0;
    $countLeaveRequests = 0;

    if (Auth::check()) {
        $curWorkPlace = auth()->user()->work_place;
        $pro_code = '0';
        $dis_code = '0';
        $location_code = '0';
        if ($curWorkPlace) {
            $pro_code = $curWorkPlace->pro_code;
            $dis_code = $curWorkPlace->dis_code;
            $location_code = $curWorkPlace->location_code;
        }

        $staffs = [];
        $staffspoe = [];
        $staffs = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
            ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
            ->where('hrmis_work_histories.cur_pos', 1)
            ->where('hrmis_work_histories.location_code', $location_code)
            ->select('hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en')
            ->distinct()
            ->pluck('payroll_id');
        // if(Auth::user()->hasRole('poe-admin')) {
        //     $staffspoe = Staff::join('hrmis_work_histories', 'hrmis_staffs.payroll_id', '=', 'hrmis_work_histories.payroll_id')
        //         ->join('sys_locations', 'hrmis_work_histories.location_code', '=', 'sys_locations.location_code')
        //         ->where('hrmis_work_histories.cur_pos', 1)
        //         ->where('hrmis_work_histories.pro_code', $pro_code)
        //         ->select('hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en')
        //         ->distinct()
        //         ->pluck('payroll_id');
        //     $countUsersNeedApproval = User::where('status', config('constants.CONST_PENDING'))
        //         ->where('validate_type', 1)
        //         ->whereIn('payroll_id', $staffs)
        //         ->count();
        //     $countUsersNeedApprovalpoe = User::where('status', config('constants.CONST_PENDING'))
        //     // ->where('validate_type', 1)
        //         ->whereIn('payroll_id', $staffspoe)
        //         ->count();
        // }


        $countLeaveRequests = StaffLeave::where('leave_type_id', 2)
            ->where('app_request', 1)
            ->where(DB::raw("IFNULL(check_status_id, 0)"), 4)
            ->whereIn('payroll_id', $staffs)
            ->count('leave_id');
        // School Director
        if (auth()->user()->hasRole('school-admin')) {
            $countStaffsNeedApproval = ProfileCheck::join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('school_check_status', 4)
                ->distinct('hrmis_profile_checks.payroll_id')
                ->count('hrmis_profile_checks.payroll_id');
        } elseif (auth()->user()->hasRole('doe-admin')) {
            $countStaffsNeedApproval = ProfileCheck::join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                //For staff in DOE
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('doe_check_status', 4)
                ->distinct('hrmis_profile_checks.payroll_id')
                ->count('hrmis_profile_checks.payroll_id');
        } elseif (auth()->user()->hasRole('poe-admin')) {
            //Staff inside POE
            $q_1 = ProfileCheck::join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('poe_check_status', 4)
                ->select('hrmis_profile_checks.payroll_id')
                ->distinct();

            //Union with Staff in school or DOE who requested to change DOB
            $staff_num = ProfileCheck::join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('hrmis_profile_checks.field_id', '011')
                ->where('pro_code', $pro_code)
                ->where('poe_check_status', 4)
                ->where(function ($query) {
                    $query->where('school_check_status', 5)
                        ->orWhere('doe_check_status', 5);
                })
                ->select('hrmis_profile_checks.payroll_id')
                ->distinct()
                ->union($q_1)
                ->count('*');
            $countStaffsNeedApproval = $staff_num;
        } elseif (auth()->user()->hasRole('dept-admin')) {
            $countStaffsNeedApproval = ProfileCheck::join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('department_check_status', 4)
                ->distinct('hrmis_profile_checks.payroll_id')
                ->count('hrmis_profile_checks.payroll_id');
        } elseif (auth()->user()->hasRole('administrator')) {
            $countStaffsNeedApproval = ProfileCheck::where('field_id', '011') //Staff's DOB
                ->where('admin_check_status', 4) //Pending for admin's approval
                ->where(function ($query) {
                    $query->where('poe_check_status', 5)
                        ->orWhere('department_check_status', 5);
                })
                ->distinct('payroll_id')
                ->count('payroll_id');
        } else {
            $countUsersNeedApproval = 0;
            $countStaffsNeedApproval = 0;
        }
    }
    $view->with('countUsersNeedApproval', $countUsersNeedApproval); 
    $view->with('countUsersNeedApprovalpoe', $countUsersNeedApprovalpoe); 
    $view->with('countStaffsNeedApproval', $countStaffsNeedApproval);
    $view->with('countCPDNeedApproval', $countCPDNeedApproval);
    $view->with('countLeaveRequests', $countLeaveRequests);
});

Route::redirect('/', '/kh/staffs');

Route::group(['prefix' => '{language}'], function () {

    Route::get('/', 'PageController@index')->name('index');
    Auth::routes([
        //'register' => false,
        'verify' => false,
        'reset' => false
    ]);

    // User account approval
    Route::get('users/registered', [UserApprovalController::class, 'userNeedApproval'])
        ->name('user.need.approval'); // User registration approval form
    Route::get('users/registeredpoe', [UserApprovalController::class, 'userNeedApprovalPOE'])
        ->name('user.need.approvalpoe'); 
    Route::put('user/{user}/registered/approval', [UserApprovalController::class, 'userApproval'])
        ->name('user.approval'); // User registration approval function
    Route::get('user/{user}/password-reset', [UserApprovalController::class, 'resetPasswordForm'])
        ->name('password.reset'); // User reset password form
    Route::get('user/{user}/password-reset-poe', [UserApprovalController::class, 'resetPasswordFormPoE'])
        ->name('password.resetpoe'); // User reset password form
    Route::put('user/{user}/password/reset', [UserApprovalController::class, 'resetPassword'])
        ->name('password.update');
    Route::put('user/{user}/password/resetpoe', [UserApprovalController::class, 'resetPasswordPoe'])
        ->name('password.updatepoe');

    // Staff Profile Verification
    Route::resource('profile', 'StaffApprovalController')->except(
        [
            'create', 'store', 'show', 'edit', 'update'
        ]
    ); //Only use destroy

    Route::get('profiles/verified', [StaffApprovalController::class, 'staffNeedApproval'])
        ->name('profile.need.approval');
    Route::get('profile/{staff}/verified/details', [StaffApprovalController::class, 'profileDetail'])
        ->name('profile.details');
    Route::post('profile/{staff}/verified/field-approval', 'StaffApprovalController@fieldCheckApproval')
        ->name('profile.fieldapproval');

    // Page not found
    Route::get('page-not-found', 'PageController@pageNotFound')->name('page.notfound');

    Route::get('multi-criteria-search', [MultiCriteriaSearchController::class, 'index'])
        ->name('multi-criteria-search.index');
    Route::get('multi-criteria-search/export-excel', [MultiCriteriaSearchController::class, 'exportExcel'])
        ->name('multi-criteria-search.exportExcel');
    Route::get('ajax/multi-criteria-search/report-fields', [MultiCriteriaSearchController::class, 'ajaxGetReportField']);
    Route::get('ajax/multi-criteria-search/{field_name}', [MultiCriteriaSearchController::class, 'ajaxGetFieldValue']);
    Route::post('ajax/multi-criteria-search/store-report-header', [MultiCriteriaSearchController::class, 'ajaxStoreReportHeader'])
        ->name('ajax-store-report-header');


    Route::get('staffs/trainees', 'StaffController@traineeList')->name('staffs.trainee-list');
    Route::put('staffs/trainees/accept', 'StaffController@acceptTraineeList')->name('staffs.accept-trainee-list');
    Route::post('staffs/trainees/{staff}/future-location/update', 'StaffController@updateTraineeFutureLocation')->name('staffs.trainees.future-location.update');

    Route::get('staffs/profile', 'StaffController@staffProfile')->name('staffs.profile');
    Route::resource('staffs', 'StaffController');

    Route::post('staffs/{staff}/store/admiration', 'StaffController@storeAdmiration')
        ->name('staffs.storeAdmiration');

    Route::resource('work-histories', 'WorkHistoryController')->only(['edit', 'update', 'destroy']);

    // Store staff work history
    Route::post('staffs/{staff}/work-history/store', 'WorkHistoryController@store')
        ->name('workHistory.store');

    // Request Cardre
    Route::get('staffs/{payoll_id}/{qual_id}/request-caredre/ByCertification', 'RequerstCardreController@requestCardreByCertification')->name('requestCardre.ByCertification');
    Route::get('staffs/{payoll_id}/{qual_id}/request-caredre/ByCertification-undo', 'RequerstCardreController@requestCardreByCertificationUndo')->name('requestCardre.ByCertificationUndo');

    Route::group(['prefix' => 'staffs/{staff}'], function () {

        // Administration certificate
        Route::get('administration-certificate', 'StaffController@printAdministrationCertificate')
            ->name('staff.printAdministrationCertificate');

        // Staff - Admiration
        Route::resource('admirations', 'AdmirationController')->except(['create', 'show']);

        // Staff - Teaching
        Route::resource('teaching', 'TeachingController')->except(['create', 'edit', 'show']);
        Route::resource('teaching-subject', 'TeachingSubjectController')->except(['index', 'create', 'show']);

        // Staff - Work history
        Route::resource('work-histories', 'WorkHistoryController')->only(['index']);

        // Staff - General knowledge
        Route::resource('general-knowledge', 'GeneralKnowledgeController')->except(['create', 'show']);

        // Staff - Qualification
        Route::resource('qualifications', 'QualificationController')->except(['create', 'show']);

        // Staff - Short Course
        Route::resource('shortcourses', 'ShortCourseController')->except(['create', 'show']);

        // Staff - Language
        Route::resource('staff-language', 'StaffLanguageController')->except(['index', 'create', 'show']);

        // Staff - Family
        Route::resource('families', 'StaffFamilyController')->except(['create', 'show']);
        Route::resource('childrens', 'ChildrenController')->except(['index', 'create', 'show']);

        Route::resource('leaves', 'LeaveController')->only(['store']);
    });

    Route::put('staffs/transfer/accept', [StaffTransferController::class, 'acceptTransfer'])->name('staffs.acceptTransfer');
    Route::put('staffs/{staff}/transfer/change-location', [StaffTransferController::class, 'chooseNewWorkplace'])
        ->name('staffTransfer.chooseNewWorkplace');

    // Staff - Leave Info
    Route::resource('leaves', 'LeaveController')->only(['edit', 'update', 'destroy']);

    // Staff - Edit Teaching
    Route::get('teaching/{teaching}/edit', 'TeachingController@edit')->name('teaching.edit');

    // Staff - TCP Profession
    Route::resource('tcp-professions', TCP\ProfessionRecordingController::class)->only(['store', 'edit', 'update', 'destroy']);

    // Staff - salary history
    Route::resource('salary-histories', 'SalaryHistoryController')->except(['index', 'create', 'show']);

    Route::resource('users', 'UserController')->except(['destroy']);
    Route::put('users/{user}/disable', [UserController::class, 'disableUser'])
        ->name('users.disable'); // Disable user account

    Route::resource('schools', 'SchoolController');


    Route::resource('roles', 'RoleController')->except(['show']);
    Route::resource('permissions', 'PermissionController')->except(['create', 'show']);

    // Contract Teacher
    Route::resource('contract-teachers', 'ContractTeacherController');
    //Route::get('contract-teachers/generate/to/staff', 'ContractTeacherController@contStaffGenerateToStaff');

    // Contract teacher - work history
    Route::resource('contract-teachers.work-histories', 'ContTeacherWorkHistoryController')
        ->except(['create', 'show']);

    // Contract teacher - teaching info
    Route::resource('contract-teachers.teaching', 'ContTeacherTeachingController')
        ->except(['create', 'show', 'edit']);

    Route::get('cont-teaching/{teaching}/edit', 'ContTeacherTeachingController@edit')->name('cont_teaching.edit');


    Route::get('other-tools', 'PageController@otherTools')->name('page.othertools');

    // Trainee Teacher
    Route::put('trainees/transfer', 'TraineeTeacherController@transfer')->name('trainees.transfer');
    Route::resource('trainees', 'TraineeTeacherController');


    // CPD & TCP Modules
    Route::resource('subject-of-study', 'SubjectOfStudyController')->except(['show']);
    Route::resource('cpd-courses', 'CPDCourseController')->except(['show']);
    Route::resource('cpd-schedule-courses', 'CPDScheduleCourseController')->except(['show']);
    Route::resource('cpd-credits', 'CPDCreditsController')->except(['show']);
    Route::get('cpd-credits/{schedule_id}/{completed_date}/edit', 'CPDCreditsController@edit')->name('cpd-credits.edit');
    Route::get('cpd-credits/{schedule_id}/view-pending-cpd', 'CPDCreditsController@viewPendingCPD')->name('cpd-credits.view-pending-cpd');
    Route::put('cpd-credits/{schedule_course}/verify-cpd', 'CPDCreditsController@verifyCPD')->name('cpd-credits.verify-cpd');
    Route::get('cpd-credits/cpd-pending-list', 'CPDCreditsController@pendingActivities')->name('cpd-credits.cpd-pending-list');

    Route::resource('cpd-providers', 'CPDProviderController')->except(['show']);
    Route::resource('cpd-teacher-educators', 'CPDTeacherEducatorController')->except(['show']);
    Route::resource('tcp-appraisals', TCP\TCPAppraisalController::class)->except(['show']);
    Route::get('tcp-appraisals/view-tcp-appraisals', 'TCP\TCPAppraisalController@viewTCPAppraisals')->name('tcp-appraisals.view-tcp-appraisals');
    Route::get('tcp-appraisals/{appraisal_id}/view-tcp-details', 'TCP\TCPAppraisalController@showDetails')->name('tcp-appraisals.details');
    Route::get('tcp-appraisals/get-position-rank', 'TCP\TCPAppraisalController@getPositionRank')->name('tcp-appraisals.get-position-rank');
    Route::post('tcp-appraisals/verify', 'TCP\TCPAppraisalController@verifyList')->name('tcp-appraisals.verify');
    Route::get('tcp-appraisals/export_to_excel', 'TCP\TCPAppraisalController@exportAppraisalsExcel')->name('tcp-appraisals.export_to_excel');

    Route::resource('tcp-assessment-ranks', 'TCPAssessmentRankController')->except(['show']);
    Route::resource('tcp-assessment-teachers', 'TCPAssessmentTeacherController')->except(['show']);
    Route::resource('tcp-assessment-specialists', 'TCPAssessmentSpecialistController')->except(['show']);
    // CPD Administrative Tools
    Route::resource('cpd-field-of-studies', 'CPDFieldOfStudyController')->except(['show']);

    // TCP Administrative Tools
    Route::resource('profession-categories', TCP\ProfessionCategoryController::class)->except(['show']);
    Route::resource('profession-ranks', TCP\ProfessionRankController::class)->except(['show']);

    // Address Info
    Route::resource('provinces', 'ProvinceController')->except(['create', 'show']);
    Route::resource('districts', 'DistrictController')->except(['create', 'show']);
    Route::resource('communes', 'CommuneController')->except(['create', 'show']);
    Route::resource('villages', 'VillageController')->except(['create', 'show']);
    Route::resource('countries', 'CountryController')->except(['create', 'show']);
    Route::resource('ethnics', 'EthnicController')->except(['create', 'show']);
    Route::resource('professional-category', 'ProfessionalCategoryController')->except(['create', 'show']);
    Route::resource('professional-type', 'ProfessionalTypeController')->except(['create', 'show']);
    Route::resource('qualification-codes', 'QualificationCodeController')->except(['create', 'show']);
    Route::resource('offices', 'OfficeController')->except(['create', 'show']);
    Route::resource('office-locations', 'OfficeLocationController')->except(['create', 'show']);
    Route::resource('salary-levels', 'SalaryLevelController')->except(['create', 'show']);
    Route::resource('cardretypes', 'CardretypeController')->except(['create', 'show']);
    Route::resource('official-ranks', 'OfficialRankController')->except(['create', 'show']);
    Route::resource('positions', 'PositionController')->except(['create', 'show']);
    Route::resource('position-levels', 'PositionLevelController')->except(['create', 'show']);
    Route::resource('position-categories', 'PositionCategoryController')->except(['create', 'show']);
    Route::resource('location-types', 'LocationTypeController')->except(['create', 'show']);
    Route::resource('subjects', 'SubjectController')->except(['create', 'show']);
    Route::resource('staff-status', 'StaffStatusController')->except(['create', 'show']);
    Route::resource('foriegn-languages', 'LanguageController')->except(['create', 'show']);
    Route::resource('trainee-status', 'TraineeStatusController')->except(['create', 'show']);
    Route::resource('position-locations', 'PositionLocationController')->except(['create', 'show']);
    Route::resource('admiration-sources', 'AdmirationSourceController')->except(['create', 'show']);
    Route::resource('admiration-types', 'AdmirationTypeController')->except(['create', 'show']);
    Route::resource('disabilities', 'DisabilityController')->except(['create', 'show']);
    Route::resource('document-types', 'DocumentTypeController')->except(['create', 'show']);
    Route::resource('education-levels', 'EducationLevelController')->except(['create', 'show']);
    Route::resource('history-types', 'HistoryTypeController')->except(['create', 'show']);
    Route::resource('grades', 'GradeController')->except(['create', 'show']);
    Route::resource('leave-types', 'LeaveTypeController')->except(['create', 'show']);
    Route::resource('regions', 'RegionController')->except(['create', 'show']);

    // Shortcourse
    Route::resource('shortcourse-categories', 'ShortCourseCategoryController')->except(['create', 'show']);
    Route::resource('training-partner-types', 'TrainingPartnerTypeController')->except(['create', 'show']);
    Route::resource('duration-types', 'DurationTypeController')->except(['create', 'show']);

    // Teaching
    Route::resource('academic-years', 'AcademicYearController')->except(['create', 'show']);

    Route::resource('contract-types', 'ContractTypeController')->except(['create', 'show']);
    Route::resource('contstaff-positions', 'ContStaffPositionController')->except(['create', 'show']);
    Route::resource('report-fields', ReportFieldController::class)->except(['create', 'show']);
});

// Get all districts of a province
Route::get('/provinces/{province}/districts', 'ProvinceController@getDistrictOfProvince');
Route::get('/provinces/{pro_code}/communes', 'ProvinceController@getCommuneOfProvince');
Route::get('/provinces/{pro_code}/villages', 'ProvinceController@getVillageOfProvince');
Route::get('/provinces/{pro_code}/locations', 'ProvinceController@getLocationOfProvince');

// Get all communes of a district
Route::get('/districts/{district}/communes', 'DistrictController@getCommuneOfDistrict');
Route::get('/districts/{district}/locations', 'DistrictController@getLocationOfDistrict');

// Get all villages of a commune
Route::get('/communes/{commune}/villages', 'CommuneController@getVillageOfCommune');

// Get offices of a location
Route::get('/locations/{location}/offices', 'LocationController@getOfficeOfLocation');
Route::get('/locations/{location}/positions', 'LocationController@getPositionOfLocation');
Route::get('locations/all', [LocationController::class, 'allLocations']);

// Get primary schools of a district
Route::get('schools/districts/{code}/primary', 'SchoolController@ajaxGetPrimarySchoolByDistrictCode');

// Get primary schools of a district
Route::get('schools/districts/{code}/primary', 'SchoolController@ajaxGetPrimarySchoolByDistrictCode');

// Get Location by name
Route::get('ajax/get-location', 'SchoolController@ajaxGetLocation');

// Get location types schools of a district
Route::get('ajax/get-location-types', 'LocationTypeController@ajaxGetLocationTypes');

// Get next increment
Route::get('ajax/get-next-gd-increment', 'SchoolController@ajaxGetNextGDIncrement');
Route::get('ajax/get-next-dep-increment', 'SchoolController@ajaxGetNextDepartmentIncrement');
Route::get('ajax/get-anowat-school-next-increment', 'SchoolController@ajaxGetAnowatSchoolNextIncrement');

// Get contract position belong to contract type
Route::get('contract-type/{contract_type}/contract-position', 'ContractTypeController@getContractPositionOfContractType');

// Filter staff info
Route::get('filter-by/{filter}/teacher', 'StaffController@filterTeacher');

// Get contract_teacher by name
Route::get('filter-by/{filter}/contract-teacher', 'ContractTeacherController@filterContractTeacher');

// Get official_rank by salary_level
Route::get('salary-level/{salary_level}/{location_kh}/official-rank', 'SalaryLevelController@getOfficialRankBySalaryLevel');

Route::get('gen-knowledge/{knowledge}/ranks', 'GeneralKnowledgeController@getGenKnowledgeRank');
Route::get('qualification/{qualification}/ranks', 'QualificationController@getQualificationRank');

// Get staff by payroll
Route::get('ajax/find-staff-by-payroll', 'StaffController@ajaxFindStaffByPayroll');

// Show staff by payroll_id
Route::get('staff/{payroll_id}', 'StaffController@showStaffByPayrollID');
Route::get('staff/filter-keyword/{filter_by}', 'StaffController@filterByKeyword');

// Get Generations for trainee
Route::get('ajax/get-trainee-academic-generations', 'TraineeTeacherController@ajaxGetAcademicGenerations');
Route::get('ajax/get-future-locations', 'TraineeTeacherController@ajaxGetFutureLocations');

Route::get(
    'provider-type/{provider_type_id}/provider-category',
    'CPDProviderController@getProviderCategoryofProviderType'
);

Route::get('field-study/{id}/subject-study', 'CPDFieldOfStudyController@showSubjectOfFieldStudy');
Route::get('/cpd-credits/{location}/{schedule_id}/staff-by-location', 'CPDCreditsController@staffListbyLocation');
Route::get('/cpd-credits/{payroll_name}/{schedule_id}/staff-by-payroll-name', 'CPDCreditsController@staffListbyPayrollName');
Route::get('/cpd-credits/{schedule_id}/staff-mobile-registrations', 'CPDCreditsController@staffListRegistrations');
Route::get('/cpd-credits/{is_mobile}/get-cpd-offerings', 'CPDCreditsController@getCPDOfferings');

// Get TCP profession rank by profession category
Route::get(
    'ajax/prof-category/{prof_cat}/prof-ranks',
    [App\Http\Controllers\TCP\ProfessionCategoryController::class, 'ajaxGetProfessionRankByCategory']
);

require __DIR__ . '/report_routes.php';
require __DIR__ . '/cpd_report_routes.php';
require __DIR__ . '/timetables_routes.php';
require __DIR__ . '/leave_request_routes.php';
