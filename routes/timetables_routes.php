<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Timetables\TimetableController;

Route::group(['prefix' => '{language}'], function () {

	Route::group(['prefix' => 'timetables'], function () {

          Route::resource('tgrades', Timetables\TimetableGradeController::class)->except(['create', 'show']);

          Route::resource('teacher-primary', Timetables\TeacherPrimaryController::class)->only(['index', 'store', 'destroy']);
          Route::resource('teacher-subjects', Timetables\TeacherSubjectController::class)->except(['create', 'show', 'edit', 'update']);
        
          Route::get('report', [TimetableController::class, 'createTimetable'])->name('timetable.create');
        
          Route::get('pre-school/report', [TimetableController::class, 'createPreSchoolTimetable'])
               ->name('timetable.createPreSchoolTimetable');
        
          Route::get('primary-school-13/{grade_level}/report', [TimetableController::class, 'createFirstPrimaryTimetable'])
               ->name('timetable.createFirstPrimaryTimetable');
        
          Route::get('primary-school-24/{grade_level}/report', [TimetableController::class, 'createSecondPrimaryTimetable'])
               ->name('timetable.createSecondPrimaryTimetable');

          // Store Timetable
          Route::post('report/store', [TimetableController::class, 'storeTimetable'])->name('timetable.store');
          Route::post('report/primary/store', [TimetableController::class, 'storePriTimetable'])->name('timetable.storePriTimetable');

          // Remove Timetable
          Route::delete('report/{year}/{location}/{day}/{hour}/{tgrade}/remove', [TimetableController::class, 'removeTimetable'])
               ->name('timetable.remove');

          // Print Timetable
          Route::get('student/{tgrade_id}', [TimetableController::class, 'printTimetable'])
               ->name('timetable.printTimetable');
        
          Route::get('teacher/{payroll_id}', [TimetableController::class, 'printTeacherTimetable'])
             ->name('timetable.printTeacherTimetable');

          // Print primary staff's duty
          Route::get('staff-duty/print', [TimetableController::class, 'printStaffDuty'])
               ->name('timetable.printStaffDuty');

          // Pre-school
          Route::get('pre-school/print', [TimetableController::class, 'printPreTimetable'])
               ->name('timetable.printPreTimetable');

          // Primary School
          Route::get('primary-school/{grade_level}/print', [TimetableController::class, 'printPrimaryTimetable'])
               ->name('timetable.printPrimaryTimetable');

          Route::get('teacher-student/all-report/print', [TimetableController::class, 'printTeacherStudentTimetable'])
               ->name('timetable.printTeacherStudentTimetable');

          Route::get('teachers/all-report/print', [TimetableController::class, 'printBulkTeacherTimetable'])
               ->name('timetable.printBulkTeacherTimetable');
    });

});
