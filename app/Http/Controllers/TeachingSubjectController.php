<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Staff;
use App\Models\TeachingSubject;

class TeachingSubjectController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    /**
     * Store teaching subject information
     *
     * @param  Staff  $staff
     * @return JSON
     */
    public function store(Staff $staff, Request $request)
    {
    	// Get total number of child
    	$totalTeachingSubject = TeachingSubject::where('payroll_id', $staff->payroll_id)->count();

    	$techingSubjectData['payroll_id'] 	= $staff->payroll_id;
    	$techingSubjectData['subject_id'] 	= $request->subject_id;
    	$techingSubjectData['grade_id'] 	= $request->grade_id;
    	$techingSubjectData['day_id'] 		= $request->day_id;
    	$techingSubjectData['hour_id'] 		= $request->hour_id;
    	$techingSubjectData['year_id'] 		= $request->year_id;
    	$techingSubjectData['created_by'] 	= Auth::user()->id;
    	$techingSubjectData['updated_by'] 	= Auth::user()->id;

    	$techingSubject = TeachingSubject::create($techingSubjectData);

    	$techingSubject->subjectName = $techingSubject->subject->subject_kh;
    	$techingSubject->total_subject = $totalTeachingSubject;

    	return $techingSubject;
    }
}
