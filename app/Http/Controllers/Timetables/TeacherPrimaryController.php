<?php

namespace App\Http\Controllers\Timetables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Location;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\Timetables\TimetableGrade;
use App\Models\Timetables\TeacherPrimary;

class TeacherPrimaryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-manage-timetables');
    }

    // Index
    public function index()
    {
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        if (request()->search) {
            $curAcademicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        }
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;

        $userLocationCode = auth()->user()->work_place->location_code;
        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', $userLocationCode)->select($locationSelectQuery)->first();

        $teacherSubjects = TeacherPrimary::where('location_code', $userLocationCode)
                                         ->where('academic_id', $academicYearID)
                                         ->get();

        // Teachers
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'position_hierarchy'];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                        ->leftJoin('sys_positions as t3', 't2.position_id', '=', 't3.position_id')
                        ->leftJoin('hrmis_staff_teachings as t4','t2.payroll_id','=','t4.payroll_id' )
                        ->where('t2.cur_pos', 1)
                        ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                        ->where('t2.location_code', $userLocationCode) 
                        //->where('hrmis_staffs.is_cont_staff', 0)
                        ->where(function($query) {
                            $query->whereNull('t2.contract_type_id');
                            $query->orWhere('t2.contract_type_id', '<>', 4);
                        })
                        ->orWhere('t4.location_code',$userLocationCode)
                        ->select($selectQuery)
                        ->groupBy($selectQuery)
                        ->groupBy('t2.payroll_id')
                        ->orderBy('position_hierarchy', 'ASC')
                        ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                        ->orderBy('hrmis_staffs.name_kh', 'ASC')
                        ->get();

        // Pre-school
        if ($userLocation->location_type_id == 18) { 
            $educationLevel = [1];
        }
        elseif ($userLocation->location_type_id == 11 || $userLocation->location_type_id == 17) { // Pri
            $educationLevel = $userLocation->multi_level_edu >= 1 ? [1, 2] : [2];
        }
        elseif ($userLocation->location_type_id == 10 || $userLocation->location_type_id == 15) { // Lower
            $educationLevel = $userLocation->multi_level_edu >= 2 ? [1, 2] : [2];
        }
        elseif ($userLocation->location_type_id == 9 || $userLocation->location_type_id == 14) { // Upper
            $educationLevel = $userLocation->multi_level_edu >= 3 ? [1, 2] : [2];
        }
        else {
            $educationLevel = [2];
        }

        // Grades of Pre-School && Primary School
        $gradeLevels = Grade::whereIn('edu_level_id', $educationLevel)->get();
        
        $grades = [];
        foreach ($gradeLevels as $grade) {
            $tgrades = TimetableGrade::where('location_code', $userLocationCode)
                                     ->where('academic_id', $academicYearID)
                                     ->where('grade_id', $grade->grade_id)
                                     ->get();

            $grades[] = $tgrades;
        }

        return view('admin.timetables.teacher_primary.index', compact(
                'academicYears', 'curAcademicYear', 'gradeLevels', 'grades', 'staffs', 'teacherSubjects'
            ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate(['payroll_id' => 'required']);

        if (!isset($request->grades)) {
            return back()->withInput()->withErrors(__('timetables.required_grade'));
        }

        $academicYear = AcademicYear::where('cur_year', 1)->select('year_id')->first();
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id')->first();
        }

        foreach ($request->grades as $grade) {
            $existingTeacher = TeacherPrimary::where('academic_id', $request->academic_id)
                                             ->where('location_code', auth()->user()->work_place->location_code)
                                             ->where('payroll_id', $request->payroll_id)
                                             ->where('tgrade_id', $grade)
                                             ->first();

            if (empty($existingTeacher)) {
                TeacherPrimary::create([
                    'academic_id' => $academicYear->year_id, 
                    'location_code' => auth()->user()->work_place->location_code, 
                    'tgrade_id' => $grade, 
                    'payroll_id' => $request->payroll_id, 
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->back()->withSuccess(__('validation.add_success'));
    }

    // Destroy
    public function destroy(TeacherPrimary $teacher_primary)
    {
        $teacher_primary->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
