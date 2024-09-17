<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiV1\CpdController;
use App\Http\Controllers\ApiV1\UserController;
use App\Http\Controllers\ApiV1\StaffController;
use App\Http\Controllers\ApiV1\LocationController;

$public = 'public';//Public API
$secure = 'secure';//Secure API (Require Token: Custom Defined Secret-Key)

Route::group(['prefix' => 'v1/'.$public], function () {
    Route::get('cpd/courses', [CpdController::class, 'getActiveCourses']);
    Route::get('cpd/courses/{id}', [CpdController::class, 'getCoursesById']);

    //  emp-reports
    // Route::get('location/getLocations', [LocationController::class, 'getLocations']);
    // Route::get('staff/getStaffs/', [StaffController::class, 'getStaffs']);
});

Route::group(['middleware' => ['checktoken'], 'prefix' => 'v1/'.$secure], function () {
    Route::get('user/{username}/{nid}/{phone}', [UserController::class, 'getUser']);
    Route::post('cpd/award-credit', [CpdController::class, 'awardCredit']);
    Route::get('cpd/courses/{scheduled_course_id}/enrollments', [CpdController::class, 'getEnrollmentBySCourseId']);

    //  emp-reports
    Route::get('location/getLocations/', [LocationController::class, 'getLocations']);
    Route::get('staff/getStaffs/', [StaffController::class, 'getStaffs']);
});