<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CPDReportController;

Route::group(['prefix' => '{language}'], function () {
	Route::group(['prefix' => 'cpd-reports'], function () {
        Route::get('/', [CPDReportController::class, 'index'])->name('cpd-reports.index');
        Route::post('staffs/got-credits', [CPDReportController::class, 'creditedStaff'])->name('cpd-reports.got-credits');
        Route::post('cpd-offerings-list', [CPDReportController::class, 'cpdOfferingsList'])->name('cpd-reports.cpd-offerings-list');
    });
});