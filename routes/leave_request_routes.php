<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LeaveRequestController;

Route::group(['prefix' => '{language}'], function () {
	Route::group(['prefix' => 'leave-requests'], function () {
        Route::get('/', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
        Route::post('approve-reject', [LeaveRequestController::class, 'approveReject'])->name('leave-requests.approve-reject');
    });
});