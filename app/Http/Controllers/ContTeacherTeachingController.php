<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\Location;
//use App\Models\ContractTeacher;
//use App\Models\ContractTeacherTeaching;
//use App\Models\ContractTeacherTeachingSubject;
use App\Models\StaffTeaching;
use App\Models\TeachingSubject;
use App\Models\DayTeaching;
use App\Models\Grade;
use App\Models\HourTeaching;
use App\Models\Subject;
use App\Models\Staff;

class ContTeacherTeachingController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:edit-cont-staffs');
    }


    /**
     * Display all contract teacher teaching info
     */
    public function index(Staff $contract_teacher)
    {
        // Get user workplace info
        $userLocationCode = auth()->user()->work_place->location_code;
        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', $userLocationCode)->select($locationSelectQuery)->first();

        // Get school level of pre-school = 1, primary_school = 2 && lower & upper secondary school = 3
        if ($userLocation->location_type_id == 18) { $schoolLevel = 1; }
        elseif ($userLocation->location_type_id == 11 || $userLocation->location_type_id == 17) { $schoolLevel = 2; }
        else { $schoolLevel = 3; }

    	$academicYears = AcademicYear::all();
    	$subjects = Subject::select('subject_id', 'subject_kh', 'subject_en')->get();
    	$grades = Grade::select('grade_id', 'grade_kh', 'grade_en')->get();
        $dayTeachings = DayTeaching::orderBy('day_order', 'asc')->take(6)->get();
        $hourTeachings = HourTeaching::where('school_level', $schoolLevel)->orderBy('hour_order', 'asc')->get();

        $teachings = StaffTeaching::where('payroll_id', $contract_teacher->payroll_id)->get();

    	return view('admin.contract_teachers.teaching', compact(
    			'academicYears', 'subjects', 'grades', 'dayTeachings', 'hourTeachings',
    			'teachings', 'contract_teacher'
    		));
    }


    /**
     * Store contract teacher teaching info
     */
    public function store($payroll_id, Request $request)
    {
    	$request->validate([
    		'year_id' => 'required',
    	]);

        StaffTeaching::create([
            'payroll_id' => $payroll_id,
            'add_teaching' => 0,
            'class_incharge' => 0,
            'chief_technical' => 0,
            'multi_grade' => $request->multi_grade ? 1 : 0,
            'double_shift' => $request->double_shift ? 1 : 0,
            'bi_language' => $request->bi_language ? 1 : 0,
            'year_id' => $request->year_id,
            'overtime' => null,
            'teach_english' => $request->teach_english ? 1 : 0,
            'triple_grade' => 0,
            'teach_cross_school' => 0,
            'location_code' => null,
            'created_by' => auth()->user()->id,
            'modif_by' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // Teaching subject data
    	foreach ($request->grade_id as $index => $gradeID) {
    		if (!empty($gradeID)) {
    			TeachingSubject::create([
                    'payroll_id' => $payroll_id,
                    'subject_id' => !is_null($request->subject_id[$index]) ? $request->subject_id[$index] : 0,
                    'grade_id' => $gradeID,
                    'grade_alias' => null,
                    'day_id' => !is_null($request->day_id[$index]) ? $request->day_id[$index] : 0,
                    'hour_id' => !is_null($request->hour_id[$index]) ? $request->hour_id[$index] : 0,
                    'year_id' => $request->year_id,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
    		}
    	}

    	return redirect()->route('contract-teachers.teaching.index', [app()->getLocale(), $payroll_id])
    					 ->with('success', __('validation.add_success'));
    }


    /**
     * Edit contract teacher - teaching info\
     */
    public function edit(StaffTeaching $teaching)
    {
        // Get user workplace info
        $userLocationCode = auth()->user()->work_place->location_code;
        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', $userLocationCode)->select($locationSelectQuery)->first();

        // Get school level of pre-school = 1, primary_school = 2 && lower & upper secondary school = 3
        if ($userLocation->location_type_id == 18) { $schoolLevel = 1; }
        elseif ($userLocation->location_type_id == 11 || $userLocation->location_type_id == 17) { $schoolLevel = 2; }
        else { $schoolLevel = 3; }

        $contract_teacher = Staff::where('payroll_id', $teaching->payroll_id)->first();

        $academicYears = AcademicYear::all();
        $subjects = Subject::select('subject_id', 'subject_kh', 'subject_en')->get();
        $grades = Grade::select('grade_id', 'grade_kh', 'grade_en')->get();
        $dayTeachings = DayTeaching::orderBy('day_order', 'asc')->take(6)->get();
        $hourTeachings = HourTeaching::where('school_level', $schoolLevel)->orderBy('hour_order', 'asc')->get();

        $teachingSubjects = TeachingSubject::where('payroll_id', $teaching->payroll_id)
                                        ->where('year_id', $teaching->year_id)
                                        ->get();

        return view('admin.contract_teachers.edit_teaching', compact(
                'contract_teacher',
                'academicYears', 'subjects', 'grades', 'dayTeachings', 'hourTeachings',
                'teaching', 'teachingSubjects'
            ));
    }


    /**
     * Update contract teacher - teaching info
     */
    public function update(Request $request, $payroll_id, StaffTeaching $teaching)
    {
        $request->validate([
            'year_id' => 'required',
        ]);

        // Teaching data
        $teaching->fill([
            'add_teaching' => 0,
            'class_incharge' => 0,
            'chief_technical' => 0,
            'multi_grade' => $request->multi_grade ? 1 : 0,
            'double_shift' => $request->double_shift ? 1 : 0,
            'bi_language' => $request->bi_language ? 1 : 0,
            'year_id' => $request->year_id,
            'overtime' => null,
            'teach_english' => $request->teach_english ? 1 : 0,
            'triple_grade' => 0,
            'teach_cross_school' => 0,
            'location_code' => null,
            'modif_by' => auth()->user()->id,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ])->save();


        // Remove existing teaching subject before add new
        $teachingSubjects = TeachingSubject::where('payroll_id', $payroll_id)
                                        ->where('year_id', $teaching->year_id)
                                        ->delete();

        
        // Teaching subject data
        foreach ($request->grade_id as $index => $gradeID) {
            if (!is_null($gradeID)) {
                TeachingSubject::create([
                    'payroll_id' => $payroll_id,
                    'subject_id' => !is_null($request->subject_id[$index]) ? $request->subject_id[$index] : 0,
                    'grade_id' => $request->grade_id[$index],
                    'grade_alias' => null,
                    'day_id' => !is_null($request->day_id[$index]) ? $request->day_id[$index] : 0,
                    'hour_id' => !is_null($request->hour_id[$index]) ? $request->hour_id[$index] : 0,
                    'year_id' => $request->year_id,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->route('contract-teachers.teaching.index', [app()->getLocale(), $payroll_id])
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove contact techer - teaching info
     */
    public function destroy($payroll_id, StaffTeaching $teaching)
    {
        // Remove existing teaching subject first
        $teachingSubjects = TeachingSubject::where('payroll_id', $teaching->payroll_id)
                                        ->where('year_id', $teaching->year_id)
                                        ->delete();

        // Then remove teaching info
        $teaching->delete();

        return $teaching;
    }
}
