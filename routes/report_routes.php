<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Reports\StaffTransferController;
use App\Http\Controllers\Reports\StaffbyAgeController;
use App\Http\Controllers\Reports\StaffbyProfessionController;
use App\Http\Controllers\Reports\StaffInWorkplaceController;
use App\Http\Controllers\Reports\StaffAllocationController;
use App\Http\Controllers\RequerstCardreController;

Route::group(['prefix' => '{language}'], function () {
	Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('staff-allocations', [StaffAllocationController::class, 'index'])->name('staff-allocation.index');
        Route::get('staffs/off-duty', [ReportController::class, 'offDutyStaff'])->name('reports.offDutyStaff');
        Route::get('staffs/leave-without-pay', [ReportController::class, 'leaveWithoutPayStaff'])->name('reports.leaveWithoutPayStaff');
        Route::get('staffs/continue-study', [ReportController::class, 'continueStudyStaff'])->name('reports.continueStudyStaff');
        Route::get('staffs/move-in', [StaffTransferController::class, 'showStaffTransferInInfo'])->name('reports.showStaffTransferInInfo');
        Route::get('staffs/leave-info', [ReportController::class, 'showStaffOnLeave'])->name('reports.showStaffOnLeave');
        
        // caredre
        Route::get('staffs/index-caredre-bycertification', [RequerstCardreController::class, 'indexRequestCardreByCertification'])->name('reports.indexRequestCardreByCertification');
        Route::get('staffs/show-caredre-bycertification', [RequerstCardreController::class, 'showRequestCardreByCertification'])->name('reports.showRequestCardreByCertification');
        Route::post('staffs/report-caredre-bycertification', [RequerstCardreController::class, 'reportRequestCardreByCertification'])->name('reports.reportRequestCardreByCertification');
        Route::post('staffs/request-caredre-bycertification/excel', [RequerstCardreController::class, 'exportCardreByCertification'])->name('reports.exportCardreByCertification');
        Route::get('staffs/index-request-caredre-bycercle', [RequerstCardreController::class, 'indexRequestCardreByCercle'])->name('reports.indexRequestCardreByCercle');
        Route::get('staffs/show-request-caredre-bycercle', [RequerstCardreController::class, 'showRequestCardreByCercle'])->name('reports.showRequestCardreByCercle');
        Route::post('staffs/report-caredre-bycercle', [RequerstCardreController::class, 'reportRequestCardreByCercle'])->name('reports.reportRequestCardreByCercle');
        Route::put('staffs/request-caredre-bycercle/verify-caredre', [RequerstCardreController::class, 'verifyCardreByCercle'])->name('reports.verifyCardreByCercle');
        Route::post('staffs/request-caredre-bycercle/excel', [RequerstCardreController::class, 'exportCardreByCercle'])->name('reports.exportCardreByCercle');

        // All staff
        Route::post('staffs/all', [ReportController::class, 'generateAllStaff'])->name('reports.generateAllStaff');
        Route::get('staffs/all/export/excel/{pro_code}/{dis_code?}/{location_code?}', 
            [ReportController::class, 'exportAllStaffExcel'])->name('reports.exportAllStaffExcel');
        Route::get('staffs/all/export/pdf/{pro_code}/{dis_code?}/{location_code?}', 
            [ReportController::class, 'exportAllStaffPDF'])->name('reports.exportAllStaffPDF');
        Route::get('staffs/all/{pro_code}/{dis_code?}/{location_code?}', [ReportController::class, 'showAllStaff'])
            ->name('reports.showAllStaff');
        
        // Staff in workplace
        Route::post('staffs/one-page-one-workplace', [StaffInWorkplaceController::class, 'generateStaffOnePageOneWorkplace'])
            ->name('reports.generateStaffOnePageOneWorkplace');
        Route::get('staffs/one-page-one-workplace/export/excel/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffInWorkplaceController::class, 'exportStaffOnePageOneWorkplaceExcel'])
            ->name('reports.exportStaffOnePageOneWorkplaceExcel');
        Route::get('staffs/one-page-one-workplace/export/pdf/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffInWorkplaceController::class, 'exportStaffOnePageOneWorkplacePDF'])
            ->name('reports.exportStaffOnePageOneWorkplacePDF');
        Route::get('staffs/one-page-one-workplace/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffInWorkplaceController::class, 'showStaffOnePageOneWorkplace'])
                ->name('reports.showStaffOnePageOneWorkplace');
        /*------Short Leave -----*/
        Route::post('staffs/staff-short-leave', [ReportController::class, 'generateShortLeave'])
        ->name('reports.generateShortLeave');
        Route::get('staffs/staff-short-leave/export/pdf/{pro_code}/{dis_code}/{location_code}/{start_date}/{end_date}', [ReportController::class, 'exportShortLeavePDF'])
        ->name('reports.exportShortLeavePDF');
        Route::get('staffs/staff-short-leave/export/excel/{pro_code}/{dis_code}/{location_code}/{start_date}/{end_date}', [ReportController::class, 'exportShortLeaveExcel'])
        ->name('reports.exportShortLeaveExcel');
        /**-----End Short Leave */

        // Staff by profession
        Route::post('staffs/staff-by-profession', [StaffbyProfessionController::class, 'generateStaffbyProfession'])
            ->name('reports.generateStaffbyProfession');
        Route::get('staffs/staff-by-profession/export/excel/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffbyProfessionController::class, 'exportStaffbyProfessionExcel'])
            ->name('reports.exportStaffbyProfessionExcel');
        Route::get('staffs/staff-by-profession/export/pdf/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffbyProfessionController::class, 'exportStaffbyProfessionPDF'])
            ->name('reports.exportStaffbyProfessionPDF');
        Route::get('staffs/staff-by-profession/{pro_code}/{dis_code?}/{location_code?}', 
            [StaffbyProfessionController::class, 'showStaffbyProfession'])
            ->name('reports.showStaffbyProfession');

        // Staff by position
        Route::post('staffs/staff-by-position', [ReportController::class, 'generateStaffbyPosition'])
            ->name('reports.generateStaffbyPosition');
        Route::get('staffs/staff-by-position/export/excel/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [ReportController::class, 'exportStaffbyPositionExcel'])->name('reports.exportStaffbyPositionExcel');
        Route::get('staffs/staff-by-position/export/pdf/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [ReportController::class, 'exportStaffbyPositionPDF'])->name('reports.exportStaffbyPositionPDF');
        Route::get('staffs/staff-by-position/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [ReportController::class, 'showStaffbyPosition'])->name('reports.showStaffbyPosition');

        // Staff by age
        Route::post('staffs/staff-by-age', [StaffbyAgeController::class, 'generateStaffbyAge'])
            ->name('reports.generateStaffbyAge');
        Route::get('staffs/staff-by-age/export/excel/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [StaffbyAgeController::class, 'exportStaffbyAgeExcel'])->name('reports.exportStaffbyAgeExcel');
        Route::get('staffs/staff-by-age/export/pdf/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [StaffbyAgeController::class, 'exportStaffbyAgePDF'])->name('reports.exportStaffbyAgePDF');
        Route::get('staffs/staff-by-age/{pro_code}/{pos_from}/{pos_to}/{dis_code?}/{location_code?}', 
            [StaffbyAgeController::class, 'showStaffbyAge'])->name('reports.showStaffbyAge');
    });
});