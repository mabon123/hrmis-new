<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\AcademicYear;
use App\Models\DayTeaching;
use App\Models\Grade;
use App\Models\HourTeaching;
use App\Models\Location;
use App\Models\PrimaryTeaching;
use App\Models\Staff;
use App\Models\StaffTeaching;
use App\Models\Subject;
use App\Models\TeachingSubject;

class TeachingController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
    }


    /**
     * List all staff's teaching information
     *
     * @param  Object  Staff  $staff
     */
    public function index(Staff $staff)
    {
    	$headerid   = $staff->payroll_id;
    	$payroll_id = $staff->payroll_id;
        $curWorkPlace = auth()->user()->work_place;
    	$academicYears  = AcademicYear::orderBy('year_id', 'asc')->get();
        $dayTeachings   = DayTeaching::orderBy('day_order', 'asc')->get();
        $hourTeachings  = HourTeaching::orderBy('hour_order', 'asc')->get();
        $subjects       = Subject::select('subject_id', 'subject_kh', 'subject_en')->get();
        $grades = Grade::select('grade_id', 'grade_kh', 'grade_en')
                        ->orderBy('edu_level_id')
                        ->orderBy('grade_id')
                        ->get();
        $locations = Location::whereIn('location_type_id', [14,15,17,18])
                            ->where('pro_code', $curWorkPlace->pro_code)                                
                             ->pluck('location_kh', 'location_code');

        /*$teachingSubjects = TeachingSubject::where('payroll_id', $staff->payroll_id)->get();*/

    	return view('admin.staffs.teaching', compact(
    		'headerid', 'payroll_id', 'academicYears', 'dayTeachings', 'hourTeachings', 'subjects',
    		'grades', 'staff', 'locations'
    	));
    }



    /**
     * Store staff's teaching info
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
        $request->validate([
            'year_id' => 'required',
        ]);
        
        // Check existing staff teaching info
        $existStaffTeaching = StaffTeaching::where('payroll_id', $staff->payroll_id)
                                           ->where('year_id', $request->year_id)
                                           ->first();

        if ($existStaffTeaching) {
            return redirect()->route('teaching.index', [app()->getLocale(), $staff->payroll_id])
                             ->withErrors(__('validation.duplicate'));
        }

        $teachingData = $request->all();

        // Staff teaching data
        $teachingData['payroll_id']         = $staff->payroll_id;
        $teachingData['add_teaching']       = $request->add_teaching ? 1 : 0;
        $teachingData['teach_english']      = $request->teach_english ? 1 : 0;
        $teachingData['class_incharge']     = $request->class_incharge ? 1 : 0;
        $teachingData['chief_technical']    = $request->chief_technical ? 1 : 0;
        $teachingData['multi_grade']        = $request->multi_grade ? 1 : 0;
        $teachingData['double_shift']       = $request->double_shift ? 1 : 0;
        $teachingData['bi_language']        = $request->bi_language ? 1 : 0;
        $teachingData['teach_cross_school'] = $request->teach_cross_school ? 1 : 0;
        $teachingData['triple_grade']       = $request->triple_grade ? 1 : 0;
        $teachingData['created_by']         = Auth::user()->id;
        $teachingData['modif_by']           = Auth::user()->id;
        
        // Store staff teaching info
        $teaching = StaffTeaching::create($teachingData);


        // Teaching subject data
        $teachingSubjectData['payroll_id']  = $staff->payroll_id;
        $teachingSubjectData['year_id']     = $request->year_id;
        $teachingSubjectData['created_by']  = Auth::user()->id;
        $teachingSubjectData['updated_by']  = Auth::user()->id;
        
        // Store teaching subject info
        //foreach($request->grade_id as $index => $gradeID) {
            if (!empty($gradeID)) {
                $teachingSubjectData['subject_id']  = !is_null($request->subject_id[$index]) ? $request->subject_id[$index] : 0;
                $teachingSubjectData['grade_id']    = $request->grade_id[$index];
                $teachingSubjectData['grade_alias'] = $request->grade_alias[$index];
                $teachingSubjectData['day_id']      = !is_null($request->day_id[$index]) ? $request->day_id[$index] : 0;
                $teachingSubjectData['hour_id']     = !is_null($request->hour_id[$index]) ? $request->hour_id[$index] : 0;
                TeachingSubject::create($teachingSubjectData);
            }            
        //}

        return redirect()->route('teaching.edit', [app()->getLocale(), $teaching->teaching_id])
                         ->with('success', __('validation.add_success'));
    }


    /**
     * Edit staff's teaching info
     *
     * @param  Object  Staff  $staff
     * @param  Object  StaffTeaching $teaching
     */
    public function edit(StaffTeaching $teaching)
    {
        $headerid = $teaching->teaching_id;

        $staff = Staff::where('payroll_id', $teaching->payroll_id)->first();
        $curWorkPlace = auth()->user()->work_place;
        $academicYears  = AcademicYear::all();        
        $dayTeachings   = DayTeaching::orderBy('day_order', 'desc')->get();
        $hourTeachings  = HourTeaching::orderBy('hour_order', 'asc')->get();
        $subjects       = Subject::select('subject_id', 'subject_kh', 'subject_en')->get();
        $grades         = Grade::select('grade_id', 'grade_kh', 'grade_en')->get();
        $locations = Location::whereIn('location_type_id', [14,15,17,18])
                            ->where('pro_code', $curWorkPlace->pro_code)
                             ->pluck('location_kh', 'location_code');

        $teachingSubjects = TeachingSubject::where('payroll_id', $staff->payroll_id)
                                           ->where('year_id', $teaching->year_id) 
                                           ->orderBy('day_id','asc')
                                           ->orderBy('hour_id','asc')
                                           ->orderBy('grade_id','asc')
                                           ->orderBy('grade_alias','asc')
                                           ->orderBy('subject_id','asc')
                                           ->get();

        return view('admin.staffs.edit_teaching', compact(
                'headerid', 'staff', 'teaching', 'academicYears', 'subjects', 'grades',
                'dayTeachings', 'hourTeachings', 'teachingSubjects', 'locations'
            ));
    }


    /**
     * Update staff's teaching info
     *
     * @param  Object  Staff  $staff
     * @param  Object  StaffTeaching $teaching
     */
    public function update(Staff $staff, StaffTeaching $teaching, Request $request)
    {
        $request->validate([
            'year_id' => 'required',
        ]);

        $teachingData = $request->all();
        
        // Staff teaching data
        $teachingData['add_teaching']       = $request->add_teaching ? 1 : 0;
        $teachingData['teach_english']      = $request->teach_english ? 1 : 0;
        $teachingData['class_incharge']     = $request->class_incharge ? 1 : 0;
        $teachingData['chief_technical']    = $request->chief_technical ? 1 : 0;
        $teachingData['multi_grade']        = $request->multi_grade ? 1 : 0;
        $teachingData['double_shift']       = $request->double_shift ? 1 : 0;
        $teachingData['bi_language']        = $request->bi_language ? 1 : 0;
        $teachingData['teach_cross_school'] = $request->teach_cross_school ? 1 : 0;
        $teachingData['location_code']      = $request->location_code ? 
                                              $request->location_code : $teaching->location_code;
        $teachingData['triple_grade']       = $request->triple_grade ? 1 : 0;
        $teachingData['modif_by']           = Auth::user()->id;
        
        // Update staff teaching info
        $teaching->fill($teachingData)->save();
        /** Teaching subject data
        $teachingSubjectData['payroll_id']  = $staff->payroll_id;
        $teachingSubjectData['year_id']     = $request->year_id;
        $teachingSubjectData['created_by']  = Auth::user()->id;
        $teachingSubjectData['updated_by']  = Auth::user()->id;
        // Remove all teaching subjects before add new
        $teachingSubjects = TeachingSubject::where('payroll_id', $staff->payroll_id)
                                           ->where('year_id', $teaching->year_id)
                                           ->delete();
        // Store new teaching subject info
        foreach($request->grade_id as $index => $gradeID) {
            if (!is_null($gradeID)) {
                $teachingSubjectData['subject_id']  = !is_null($request->subject_id[$index]) ? $request->subject_id[$index] : 0;
                $teachingSubjectData['grade_id']    = $request->grade_id[$index];
                $teachingSubjectData['grade_alias'] = $request->grade_alias[$index];
                $teachingSubjectData['day_id']      = !is_null($request->day_id[$index]) ? $request->day_id[$index] : 0;
                $teachingSubjectData['hour_id']     = !is_null($request->hour_id[$index]) ? $request->hour_id[$index] : 0;
                TeachingSubject::create($teachingSubjectData);
            }
        }
       */
        return redirect()->route('teaching.edit', [app()->getLocale(), $teaching->teaching_id])
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove staff's teaching info
     *
     * @param  Object  Staff  $staff
     * @param  Object  StaffTeaching $teaching
     

    public function destroy(Staff $staff, StaffTeaching $teaching)
    {
        // Remove all teaching subjects before add new
        $teachingSubjects = TeachingSubject::where('payroll_id', $staff->payroll_id)
                                           ->where('year_id', $teaching->year_id)
                                           ->delete();

        // Remove teaching info
        $teaching->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
    */
}
