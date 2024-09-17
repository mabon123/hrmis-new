<?php

namespace App\Http\Controllers\Timetables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Location;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\Timetables\TimetableGrade;
use App\Models\Timetables\TeacherPrimary;
use App\Models\Timetables\TeacherSubject;


class TeacherSubjectController extends Controller
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

        // Teachers
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob','position_hierarchy'];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                        ->leftJoin('sys_positions as t3', 't2.position_id', '=', 't3.position_id')
                        ->leftJoin('hrmis_staff_teachings as t4','t2.payroll_id','=','t4.payroll_id' )
                        ->where('t2.cur_pos', 1)
                        ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                        ->where('t2.location_code', $userLocationCode)                          
                        ->where(function($query){
                            $query->whereNull('t2.contract_type_id');
                            $query->orWhere('t2.contract_type_id', '<>', 4);
                        })
                        ->orWhere('t4.location_code',$userLocationCode)                                             
                        ->select($selectQuery)
                        ->groupBy($selectQuery)
                        ->groupBy('t2.payroll_id')
                        //->orderBy('subject_id1','ASC') 
                        //->orderBy('subject_id2','ASC')                       
                        ->orderBy('position_hierarchy', 'ASC')
                        ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                        ->orderBy('hrmis_staffs.name_kh', 'ASC')
                        ->get();

        // Set education level
        if ($userLocation->location_type_id == 18) { 
            $educationLevel = [1]; 
            
            $subjects = Subject::where('edu_level_id', 1)
                               ->orderBy('subject_kh', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }

        // Primary school
        elseif ($userLocation->location_type_id == 17 || $userLocation->location_type_id == 11) {
            $educationLevel = $userLocation->multi_level_edu == 1 ? [1, 2] : [2];

            $subjects = Subject::whereIn('subject_shortcut', ['Ed', 'En', 'M', 'K'])
                               ->orWhere('edu_level_id', 2)
                               ->orderBy('subject_hierachy', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }

        // Lower secondar school
        elseif ($userLocation->location_type_id == 15 || $userLocation->location_type_id == 10) {
            $educationLevel = [3];

            $subjects = Subject::where(function($query) {
                                    $query->where('h_g7', '<>', 0);
                                    $query->orWhere('h_g8', '<>', 0);
                                    $query->orWhere('h_g9', '<>', 0);
                               })
                               ->where('edu_level_id', 4)
                               ->orderBy('subject_kh', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }

        // Upper secondary school
        elseif ($userLocation->location_type_id == 14 || $userLocation->location_type_id == 5 || $userLocation->location_type_id == 6 || $userLocation->location_type_id == 7) {
            $educationLevel = $userLocation->multi_level_edu >= 1 ? [3, 4] : [4];
            
            $subjects = Subject::where('edu_level_id', 4)
                               ->orderBy('subject_kh', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }

        elseif ($userLocation->location_type_id == 3) { 
            $educationLevel = [5]; 

            $subjects = Subject::where('edu_level_id', 5)
                               ->orderBy('subject_kh', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }
        else  { 
            $educationLevel = [6]; 

            $subjects = Subject::where('edu_level_id', 6)
                               ->orderBy('subject_kh', 'ASC')
                               ->pluck('subject_kh', 'subject_id')
                               ->all();
        }

        // Get grades by education level
        $grades = Grade::whereIn('edu_level_id', $educationLevel)->pluck('grade_kh', 'grade_id')->all();

        $teacherSubjects = TeacherSubject::where('academic_id', $academicYearID)
                                         ->where('location_code', $userLocationCode)
                                         ->orderBy('grade_id','ASC')
                                         ->get();

        return view('admin.timetables.teacher_subjects.index', compact(
                'academicYears', 'curAcademicYear', 'subjects', 'grades', 'staffs', 
                'teacherSubjects', 'userLocation'
            ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate(['subject_id' => 'required']);

        if (!isset($request->grades) || !isset($request->teachers)) {
            return back()->withInput()->withErrors(__('validation.required_grade_and_teacher'));
        }

        $academicYear = AcademicYear::where('cur_year', 1)->select('year_id')->first();
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id')->first();
        }

        // Get subject info
        $subject = Subject::where('subject_id', $request->subject_id)->select('subject_shortcut')->first();
        
        foreach ($request->teachers as $teacher) {
            // Generate teacher subject data
            $existingTeacher = TeacherSubject::where('location_code', auth()->user()->work_place->location_code)
                                             ->where('academic_id', $academicYear->year_id)
                                             ->where('subject_id', $request->subject_id)
                                             ->where('payroll_id', $teacher)
                                             ->first();

            $existingTS = TeacherSubject::where('location_code', auth()->user()->work_place->location_code)
                                        ->where('academic_id', $academicYear->year_id)
                                        ->where('subject_id', $request->subject_id)
                                        ->orderBy(DB::raw('CONVERT(IF(RIGHT(`teacher_subject`,2) REGEXP "^[0-9]+$" =1,RIGHT(`teacher_subject`,2),RIGHT(`teacher_subject`,1)),UNSIGNED INT)'), 'DESC')
                                        ->first();

            $teacherSubject = $subject->subject_shortcut.'1';

            if ($existingTeacher) { $teacherSubject = $existingTeacher->teacher_subject; }
            elseif ($existingTS) {
                $lastNumTS = preg_replace('/[^0-9]/','',$existingTS->teacher_subject);
                $teacherSubject = $subject->subject_shortcut.''.($lastNumTS + 1);
            }

            foreach ($request->grades as $grade) {
                $duplicatedTeacherSubject = TeacherSubject::where('location_code', auth()->user()->work_place->location_code)
                                                          ->where('academic_id', $academicYear->year_id)
                                                          ->where('payroll_id', $teacher)
                                                          ->where('subject_id', $request->subject_id)
                                                          ->where('grade_id', $grade)
                                                          ->first();
                if (empty($duplicatedTeacherSubject)) {
                    TeacherSubject::create([
                        'academic_id' => $academicYear->year_id, 
                        'location_code' => auth()->user()->work_place->location_code, 
                        'subject_id' => $request->subject_id, 
                        'grade_id' => $grade, 
                        'payroll_id' => $teacher, 
                        'teacher_subject' => $teacherSubject
                    ]);
                }
            }
        }

        return redirect()->back()->withSuccess(__('validation.add_success'));
    }

    // Destroy
    public function destroy(TeacherSubject $teacher_subject)
    {
        $teacher_subject->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
