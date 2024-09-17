<?php

namespace App\Http\Controllers\Timetables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AcademicYear;
use App\Models\DayTeaching;
use App\Models\Grade;
use App\Models\HourTeaching;
use App\Models\Location;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\Timetables\TimetableGrade;
use App\Models\Timetables\TeacherPrimary;
use App\Models\Timetables\TeacherSubject;
use App\Models\Timetables\Timetable;
use App\Models\Timetables\TimetablePrimary;

class TimetableController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-manage-timetables');
    }

    // Pre-School Timetable
    public function createPreSchoolTimetable()
    {
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();

        if (request()->search) {
            $curAcademicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        }
        else {
            $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        }
        
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;
        $userLocationCode = auth()->user()->work_place->location_code;

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 1)->where('shift', 1)->orderBy('hour_order', 'ASC')->get();

        $subjects = Subject::whereIn('subject_shortcut', ['SS', 'Sc'])
                           ->orWhere('edu_level_id', 1)
                           ->orderBy('subject_hierachy', 'ASC')
                           ->select('subject_kh', 'subject_id')
                           ->get();

        // Getting Timetables Info
        $timetables = [];
        $hourSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $timetable = TimetablePrimary::where('location_code', $userLocationCode)
                                    ->where('academic_id', $academicYearID)
                                    ->where('hour_id', $hour->hour_id)
                                    ->where('day_id', $day->day_id)
                                    ->where('shift', 'm')
                                    ->first();
                
                $hourSlots[] = $timetable;
            }
            
            $timetables[] = $hourSlots;
            $hourSlots = [];
        }

        //return $timetables;

        return view('admin.timetables.pre_schools.index', compact(
                    'academicYearID', 'userLocationCode', 'academicYears', 'curAcademicYear', 
                    'tdays', 'thours', 'subjects', 'timetables'
                ));
    }

    // Primary School Timetable - Grade 1 - 3
    public function createFirstPrimaryTimetable($grade_level)
    {
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();

        if (request()->search) {
            $curAcademicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        }
        else {
            $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        }
        
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;
        $userLocationCode = auth()->user()->work_place->location_code;

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->get();
        $thours = HourTeaching::where('school_level', 2)->where('shift', 1)->orderBy('hour_order', 'ASC')->get();
        $ahours = HourTeaching::where('school_level', 2)->where('shift', 2)->orderBy('hour_order', 'ASC')->get();

        $subjects = Subject::whereIn('subject_shortcut', ['Ed', 'En','Ar','IT1', 'M', 'K','S'])
                           ->orWhere('edu_level_id', 2)
                           ->orderBy('subject_hierachy', 'ASC')
                           ->select('subject_kh', 'subject_id')
                           ->get();

        // Get morning timetable
        $morningTimetables = []; $morningSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $morning = TimetablePrimary::where('location_code', $userLocationCode)
                                           ->where('academic_id', $academicYearID)
                                           ->where('hour_id', $hour->hour_id)
                                           ->where('day_id', $day->day_id)
                                           ->where('shift', 'm1')
                                           ->first();
                
                $morningSlots[] = $morning;
            }
            
            $morningTimetables[] = $morningSlots;
            $morningSlots = [];
        }

        // Get afternoon timetable
        $afternoonTimetables = []; $afternoonSlots = [];

        foreach ($ahours as $ahour) {
            foreach ($tdays as $day) {
                $afternoon = TimetablePrimary::where('location_code', $userLocationCode)
                                             ->where('academic_id', $academicYearID)
                                             ->where('hour_id', $ahour->hour_id)
                                             ->where('day_id', $day->day_id)
                                             ->where('shift', 'a1')
                                             ->first();
                
                $afternoonSlots[] = $afternoon;
            }
            
            $afternoonTimetables[] = $afternoonSlots;
            $afternoonSlots = [];
        }

        return view('admin.timetables.primary.index', compact(
                'academicYearID', 'userLocationCode', 'academicYears', 'curAcademicYear', 'grade_level', 
                'tdays', 'thours', 'ahours', 'subjects', 'morningTimetables', 'afternoonTimetables'
            ));
    }

    // Primary School Timetable - Grade 4 - 6
    public function createSecondPrimaryTimetable($grade_level)
    {
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();

        if (request()->search) {
            $curAcademicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        }
        else {
            $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        }
        
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;
        $userLocationCode = auth()->user()->work_place->location_code;

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->get();
        $thours = HourTeaching::where('school_level', 2)->where('shift', 1)->orderBy('hour_order', 'ASC')->get();
        $ahours = HourTeaching::where('school_level', 2)->where('shift', 2)->orderBy('hour_order', 'ASC')->get();

        $subjects = Subject::whereIn('subject_shortcut', ['Ed', 'En','Ar','IT1', 'M', 'K','S'])
                           ->orWhere('edu_level_id', 2)
                           ->orderBy('subject_hierachy', 'ASC')
                           ->select('subject_kh', 'subject_id')
                           ->get();

        // Get morning timetable
        $morningTimetables = []; $morningSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $morning = TimetablePrimary::where('location_code', $userLocationCode)
                                           ->where('hour_id', $hour->hour_id)
                                           ->where('day_id', $day->day_id)
                                           ->where('shift', 'm2')
                                           ->first();
                
                $morningSlots[] = $morning;
            }

            $morningTimetables[] = $morningSlots;
            $morningSlots = [];
        }

        // Get afternoon timetable
        $afternoonTimetables = []; $afternoonSlots = [];

        foreach ($ahours as $ahour) {
            foreach ($tdays as $day) {
                $afternoon = TimetablePrimary::where('location_code', $userLocationCode)
                                             ->where('hour_id', $ahour->hour_id)
                                             ->where('day_id', $day->day_id)
                                             ->where('shift', 'a2')
                                             ->first();
                
                $afternoonSlots[] = $afternoon;
            }

            $afternoonTimetables[] = $afternoonSlots;
            $afternoonSlots = [];
        }

        return view('admin.timetables.primary.index2', compact(
                'academicYearID', 'userLocationCode', 'academicYears', 'curAcademicYear', 'grade_level', 
                'tdays', 'thours', 'ahours', 'subjects', 'morningTimetables', 'afternoonTimetables'
            ));
    }
    
    // Create
    public function createTimetable()
    {
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;

        $userLocationCode = auth()->user()->work_place->location_code;
        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', $userLocationCode)->select($locationSelectQuery)->first();

        // Grades
        $tgrades = TimetableGrade::join('sys_grades', 'timetable_grades.grade_id', '=', 'sys_grades.grade_id')
                                 ->where('location_code', $userLocationCode)
                                 ->where('academic_id', $academicYearID)
                                 ->whereIn('edu_level_id', [3, 4])
                                 ->orderBy('timetable_grades.grade_id', 'ASC')
                                 ->orderBy('timetable_grades.grade_name','ASC')
                                 ->get();
        
        // Filters
        if (request()->search && request()->grade_id) {
            $tgrades = TimetableGrade::where('academic_id', $academicYearID)
                                     ->where('location_code', $userLocationCode)
                                     ->where('grade_id', request()->grade_id)
                                     ->orderBy('grade_id', 'ASC')
                                     ->get();
        }

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 3)->orderBy('hour_order', 'ASC')->get();

        $grades = Grade::whereIn('edu_level_id', [3, 4])->orderBy('edu_level_id', 'ASC')->pluck('grade_kh', 'grade_id')->all();

        // Subject by Grade
        $numGrades = TimetableGrade::where('academic_id', $academicYearID)
                                   ->where('location_code', $userLocationCode)
                                   ->select('grade_id')
                                   ->groupBy('grade_id')
                                   ->get();

        $subjectGrades = [];
        
        foreach ($numGrades as $numGrade) {
            $teacherSubjects = TeacherSubject::where('academic_id', $academicYearID)
                                             ->where('location_code', $userLocationCode)
                                             ->where('grade_id', $numGrade->grade_id)
                                             ->get();
            
            if ($numGrade->grade_id == 1) { $subjectGrades[0] = $teacherSubjects; } // Grade #1
            elseif ($numGrade->grade_id == 2) { $subjectGrades[1] = $teacherSubjects; } // Grade #2
            elseif ($numGrade->grade_id == 3) { $subjectGrades[2] = $teacherSubjects; } // Grade #3
            elseif ($numGrade->grade_id == 4) { $subjectGrades[3] = $teacherSubjects; } // Grade #4
            elseif ($numGrade->grade_id == 5) { $subjectGrades[4] = $teacherSubjects; } // Grade #5
            elseif ($numGrade->grade_id == 6) { $subjectGrades[5] = $teacherSubjects; } // Grade #6
            elseif ($numGrade->grade_id == 7) { $subjectGrades[6] = $teacherSubjects; } // Grade #7
            elseif ($numGrade->grade_id == 8) { $subjectGrades[7] = $teacherSubjects; } // Grade #8
            elseif ($numGrade->grade_id == 9) { $subjectGrades[8] = $teacherSubjects; } // Grade #9
            elseif ($numGrade->grade_id == 10) { $subjectGrades[9] = $teacherSubjects; } // Grade #10
            elseif ($numGrade->grade_id == 11) { $subjectGrades[10] = $teacherSubjects; } // Grade #11
            elseif ($numGrade->grade_id == 12) { $subjectGrades[11] = $teacherSubjects; } // Grade #12
            elseif ($numGrade->grade_id == 15) { $subjectGrades[14] = $teacherSubjects; } // Grade #01
            elseif ($numGrade->grade_id == 16) { $subjectGrades[15] = $teacherSubjects; } // Grade #02
            elseif ($numGrade->grade_id == 31) { $subjectGrades[30] = $teacherSubjects; } // Grade #03
            elseif ($numGrade->grade_id == 33) { $subjectGrades[32] = $teacherSubjects; } // Grade #03
            elseif ($numGrade->grade_id == 34) { $subjectGrades[33] = $teacherSubjects; } // Grade #03
            else { $subjectGrades[12] = $teacherSubjects; } // Grade #12
        }

        // Getting Timetables Info
        $timetables = [];
        $hourSlots = [];
        $daySlots = [];

        foreach ($tdays as $day) {
            foreach ($thours as $hour) {
                foreach ($tgrades as $grade) {
                    $timetable = Timetable::join('timetable_teacher_subjects as t1', 'timetables.teacher_subject_id', '=', 't1.teacher_subject_id')
                                          ->where('timetables.location_code', $userLocationCode)
                                          ->where('timetables.hour_id', $hour->hour_id)
                                          ->where('timetables.day_id', $day->day_id)
                                          ->where('timetables.tgrade_id', $grade->tgrade_id)
                                          ->first();

                    $hourSlots[] = $timetable;
                }
                $daySlots[] = $hourSlots;
                $hourSlots = [];
            }
            $timetables[] = $daySlots;
            $daySlots = [];
        }
        
        return view('admin.timetables.index', compact(
                'academicYearID', 'userLocationCode', 'academicYears', 'numGrades', 'curAcademicYear', 
                'tgrades', 'tdays', 'thours', 'subjectGrades', 'timetables', 'grades'
            ));
    }

    // Store primary timetable
    public function storePriTimetable(Request $request)
    {
        // Store New Timetable
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $academicYear = AcademicYear::where('cur_year', 1)->first();
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        }
        //$academicYearID = request()->academic_id ? request()->academic_id : $academicYear->year_id;

        //$userLocationCode = auth()->user()->work_place->location_code;
        //$userLocation = Location::where('location_code', $userLocationCode)->select('location_type_id')->first();

        // If existed, then update the record
        $existingTimetable = TimetablePrimary::where('location_code', auth()->user()->work_place->location_code)
                                             ->where('academic_id', $academicYear->year_id)
                                             ->where('day_id', $request->day_id)
                                             ->where('hour_id', $request->hour_id)
                                             ->where('shift', $request->shift)
                                             ->first();

        if ($existingTimetable) {
            $existingTimetable->fill([
                'subject_id' => $request->subject_id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ])->save();

            return $existingTimetable;
        }

        // Create
        $timetable = TimetablePrimary::create([
            'location_code' => auth()->user()->work_place->location_code,
            'academic_id' => $academicYear->year_id,
            'day_id' => $request->day_id,
            'hour_id' => $request->hour_id,
            'subject_id' => $request->subject_id,
            'shift' => $request->shift,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        return $timetable;
    }

    // Store - Ajax
    public function storeTimetable(Request $request)
    {
        // Handling Duplicated Schedule
        $tSubject = TeacherSubject::where('teacher_subject_id', $request->teacher_subject_id)->first();
        $payrollID = $tSubject->payroll_id;

        $isDuplicatedTimetable = Timetable::join('timetable_teacher_subjects AS t2', 'timetables.teacher_subject_id', '=', 't2.teacher_subject_id')
                                          ->where('timetables.academic_id', $request->academic_id)
                                          ->where('timetables.location_code', $request->location_code)
                                          ->where('timetables.day_id', $request->day_id)
                                          ->where('timetables.hour_id', $request->hour_id)
                                          ->where('t2.payroll_id', $payrollID)
                                          ->first();

        if ($isDuplicatedTimetable) {
            return 'duplicated';
        }

        // Find Existing Timetable & Remove
        $existingTimetable = Timetable::where('academic_id', $request->academic_id)
                                      ->where('location_code', $request->location_code)
                                      ->where('day_id', $request->day_id)
                                      ->where('hour_id', $request->hour_id)
                                      ->where('tgrade_id', $request->tgrade_id)
                                      ->first();

        if ($existingTimetable) {
            $existingTimetable->delete();
        }

        // Store New Timetable
        $academicYears = AcademicYear::pluck('year_kh', 'year_id')->all();
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;

        $userLocationCode = auth()->user()->work_place->location_code;
        $userLocation = Location::where('location_code', $userLocationCode)->select('location_type_id')->first();

        // Create
        $timetable = Timetable::create([
            'academic_id' => $request->academic_id,
            'location_code' => $request->location_code,
            'day_id' => $request->day_id,
            'hour_id' => $request->hour_id,
            'tgrade_id' => $request->tgrade_id,
            'teacher_subject_id' => $request->teacher_subject_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $timetable;
    }

    // Remove Timetable
    public function removeTimetable($academic_id, $location_code, $day_id, $hour_id, $tgrade_id)
    {
        // Find Existing Timetable & Remove
        $existingTimetable = Timetable::where('academic_id', $academic_id)
                                      ->where('location_code', $location_code)
                                      ->where('day_id', $day_id)
                                      ->where('hour_id', $hour_id)
                                      ->where('tgrade_id', $tgrade_id)
                                      ->first();

        if ($existingTimetable) {
            $existingTimetable->delete();
        }

        return 'success';
    }

    // Print Timetable
    public function printTimetable($p_tgrade_id)
    {
        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 3)->whereNotIn('hour_id', [0, 100])->orderBy('hour_order', 'ASC')->get();
        $tgrade = TimetableGrade::where('tgrade_id', $p_tgrade_id)->first();
        $curAcademicYear = AcademicYear::where('cur_year', 1)->first();

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'location_kh')
                                 ->first();

        // Timetable
        $timetables = [];
        $hourSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $timetable = Timetable::where('location_code', auth()->user()->work_place->location_code)
                                      ->where('tgrade_id', $p_tgrade_id)
                                      ->where('day_id', $day->day_id)
                                      ->where('hour_id', $hour->hour_id)
                                      ->first();

                $hourSlots[] = $timetable;
            }

            $timetables[] = $hourSlots;
            $hourSlots = [];
        }

        //return $timetables;

        return view('admin.timetables.prints.student', compact(
                'tdays', 'thours', 'tgrade', 'curAcademicYear', 'timetables', 'userWorkplace'
            ));
    }

    // Timetable for Teacher
    public function printTeacherTimetable($payroll_id)
    {
        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 3)->whereNotIn('hour_id', [0, 100])->orderBy('hour_order', 'ASC')->get();
        $staff = Staff::where('payroll_id', $payroll_id)->select('surname_kh', 'name_kh','phone')->first();

        if (request()->academic_id) {
            $curAcademicYear = AcademicYear::where('year_id', request()->academic_id)->first();
        } else {
            $curAcademicYear = AcademicYear::where('cur_year', 1)->first();
        }

        $classToughts = Timetable::join('timetable_grades', 'timetables.tgrade_id', '=', 'timetable_grades.tgrade_id')
                                 ->join('timetable_teacher_subjects as t1', 'timetables.teacher_subject_id', '=', 't1.teacher_subject_id')
                                 ->join('sys_grades', 'timetable_grades.grade_id', '=', 'sys_grades.grade_id')
                                 ->where('timetables.location_code', auth()->user()->work_place->location_code)
                                 ->where('t1.payroll_id', $payroll_id)
                                 ->where('timetables.academic_id', $curAcademicYear->year_id)
                                 ->select('sys_grades.grade_kh', 'timetable_grades.grade_name')
                                 ->groupBy('sys_grades.grade_kh', 'timetable_grades.grade_name')
                                 ->get();

        $classIncharge = TimetableGrade::where('location_code', auth()->user()->work_place->location_code)
                                       ->where('academic_id', $curAcademicYear->year_id)
                                       ->where('payroll_id', $payroll_id)
                                       ->first();

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'location_kh')
                                 ->first();

        // Timetable
        $timetables = [];
        $hourSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $timetable = Timetable::join('timetable_teacher_subjects AS t2', 'timetables.teacher_subject_id', '=', 't2.teacher_subject_id')
                                      ->where('timetables.location_code', auth()->user()->work_place->location_code)
                                      ->where('timetables.academic_id', $curAcademicYear->year_id)
                                      ->where('timetables.day_id', $day->day_id)
                                      ->where('timetables.hour_id', $hour->hour_id)
                                      ->where('t2.payroll_id', $payroll_id)
                                      ->first();

                $hourSlots[] = $timetable;
            }

            $timetables[] = $hourSlots;
            $hourSlots = [];
        }

        return view('admin.timetables.prints.teacher', compact(
                'tdays', 'thours', 'staff', 'curAcademicYear', 'userWorkplace', 'timetables', 
                'classIncharge', 'classToughts'
            ));
    }

    // Staff duty
    public function printStaffDuty()
    {
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id', 'year_kh')->first();
        } else {
            $academicYear = AcademicYear::where('cur_year', 1)->select('year_id', 'year_kh')->first();
        }

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'dis_code', 'location_kh')
                                 ->first();

       // $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'position_hierarchy', 'position_kh','cont_pos_id'];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                        ->leftJoin('sys_positions as t3', 't2.position_id', '=', 't3.position_id')
                        ->leftJoin('timetable_teacher_primary as t4', 't2.payroll_id', '=', 't4.payroll_id')
                        ->LEFTJOIN ('sys_contract_types AS t5','t2.contract_type_id','=','t5.contract_type_id')
                        ->where('t2.cur_pos', 1)                        
                        ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                        //->where('hrmis_staffs.is_cont_staff', 0)
                        ->where('t2.location_code', auth()->user()->work_place->location_code)
                        ->where(function($query){
                            $query->whereNull('t2.contract_type_id');
                            $query->orWhere('t2.contract_type_id', '<>', 4);
                        })
                        ->select('hrmis_staffs.payroll_id','surname_kh','name_kh','sex','dob','position_hierarchy',DB::raw('if(t2.`position_id` IS NOT NULL,`position_kh`,t5.`contract_type_kh`) as position_kh'),'cont_pos_id')
                        ->groupBy('hrmis_staffs.payroll_id')
                        ->orderBy('t2.contract_type_id','ASC')
                        ->orderBy('position_hierarchy', 'ASC')
                        ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                        ->orderBy('hrmis_staffs.name_kh', 'ASC')
                        
                        ->get();

        $teacherPrimaries = [];

        foreach ($staffs as $staff) {
            $teacherPrimary = TeacherPrimary::join('timetable_grades', 'timetable_teacher_primary.tgrade_id', '=', 'timetable_grades.tgrade_id')
                                            ->leftjoin('sys_grades', 'timetable_grades.grade_id', '=', 'sys_grades.grade_id')
                                            ->where('timetable_teacher_primary.payroll_id', $staff->payroll_id)
                                            ->select('teacher_primary_id',  DB::raw('group_concat("-",sys_grades.grade_kh,timetable_grades.grade_name) as grade_kh'), 'timetable_grades.grade_name')
                                            ->where('timetable_grades.academic_id',$academicYear->year_id)
                                            ->first();
            $teacherPrimaries[] = $teacherPrimary;
        }

        return view('admin.timetables.prints.teacher_duty', compact(
                'staffs', 'teacherPrimaries', 'academicYear', 'userWorkplace'
            ));
    }

    // Pre-school Timetable Template - Print
    public function printPreTimetable()
    {
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id', 'year_kh')->first();
        } else {
            $academicYear = AcademicYear::where('cur_year', 1)->select('year_id', 'year_kh')->first();
        }

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 1)->where('shift', 1)->orderBy('hour_order', 'ASC')->get();

        // Getting Timetables Info
        $timetables = [];
        $hourSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $timetable = TimetablePrimary::join('sys_subjects', 'timetable_primaries.subject_id', '=', 'sys_subjects.subject_id')
                                             ->where('location_code', auth()->user()->work_place->location_code)
                                             ->where('academic_id', $academicYear->year_id)
                                             ->where('hour_id', $hour->hour_id)
                                             ->where('day_id', $day->day_id)
                                             ->where('shift', 'm')
                                             ->select('timetable_primary_id', 'academic_id', 'hour_id', 'day_id', 'subject_kh')
                                             ->first();
                
                $hourSlots[] = $timetable;
            }
            
            $timetables[] = $hourSlots;
            $hourSlots = [];
        }

        return view('admin.timetables.prints.pre_school', compact(
                'tdays', 'thours', 'academicYear', 'timetables'
            ));
    }

    // Print primary school timetable template
    public function printPrimaryTimetable($grade_level)
    {
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id', 'year_kh')->first();
        } else {
            $academicYear = AcademicYear::where('cur_year', 1)->select('year_id', 'year_kh')->first();
        }

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'dis_code', 'schoolclaster')
                                 ->first();

        $schoolMaster = Location::where('location_code', $userWorkplace->schoolclaster)->select('location_kh')->first();

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', 2)->where('shift', 1)->orderBy('hour_order', 'ASC')->get();
        $ahours = HourTeaching::where('school_level', 2)->where('shift', 2)->orderBy('hour_order', 'ASC')->get();
        $shifts = $grade_level == '13' ? ['m1', 'a1'] : ['m2', 'a2'];

        // Get morning timetable
        $morningTimetables = []; $morningSlots = [];

        foreach ($thours as $hour) {
            foreach ($tdays as $day) {
                $morning = TimetablePrimary::join('sys_subjects', 'timetable_primaries.subject_id', '=', 'sys_subjects.subject_id')
                                           ->where('location_code', auth()->user()->work_place->location_code)
                                           ->where('academic_id', $academicYear->year_id)
                                           ->where('hour_id', $hour->hour_id)
                                           ->where('day_id', $day->day_id)
                                           ->where('shift', $shifts[0])
                                           ->select('timetable_primary_id', 'academic_id', 'hour_id', 'day_id', 'subject_kh')
                                           ->first();
                
                $morningSlots[] = $morning;
            }
            
            $morningTimetables[] = $morningSlots;
            $morningSlots = [];
        }

        // Get afternoon timetable
        $afternoonTimetables = []; $afternoonSlots = [];

        foreach ($ahours as $ahour) {
            foreach ($tdays as $day) {
                $afternoon = TimetablePrimary::join('sys_subjects', 'timetable_primaries.subject_id', '=', 'sys_subjects.subject_id')
                                             ->where('location_code', auth()->user()->work_place->location_code)
                                             ->where('academic_id', $academicYear->year_id)
                                             ->where('hour_id', $ahour->hour_id)
                                             ->where('day_id', $day->day_id)
                                             ->where('shift', $shifts[1])
                                             ->select('timetable_primary_id', 'academic_id', 'hour_id', 'day_id', 'subject_kh')
                                             ->first();
                
                $afternoonSlots[] = $afternoon;
            }
            
            $afternoonTimetables[] = $afternoonSlots;
            $afternoonSlots = [];
        }

        return view('admin.timetables.prints.primary_school', compact(
                'tdays', 'thours', 'ahours', 'academicYear', 'morningTimetables', 'afternoonTimetables', 
                'userWorkplace', 'schoolMaster', 'grade_level'
            ));
    }

    // Teacher - Student
    public function printTeacherStudentTimetable()
    {
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id', 'year_kh')->first();
        } else {
            $academicYear = AcademicYear::where('cur_year', 1)->select('year_id', 'year_kh')->first();
        }

        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', auth()->user()->work_place->location_code)->select($locationSelectQuery)->first();

        if ($userLocation->location_type_id == 18) { $schoolLevel = 1; }
        elseif ($userLocation->location_type_id == 11 || $userLocation->location_type_id == 17) { $schoolLevel = 2; }
        else { $schoolLevel = 3; }

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'location_kh')
                                 ->first();

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', $schoolLevel)
                              ->whereIn('hour_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
                              ->orderBy('hour_order', 'ASC')
                              ->get();

        $grades = TimetableGrade::join('sys_grades', 'timetable_grades.grade_id', '=', 'sys_grades.grade_id')
                                ->where('timetable_grades.location_code', auth()->user()->work_place->location_code)
                                ->where('timetable_grades.academic_id', $academicYear->year_id)
                                ->whereIn('sys_grades.edu_level_id', [3, 4])
                                ->select('tgrade_id', 'timetable_grades.grade_id', 'grade_name', 'payroll_id')
                                ->orderBy('timetable_grades.grade_id', 'ASC')
                                ->orderBy('grade_name', 'ASC')
                                ->get();

        // Get timetable
        $timetables = [];
        $hourSlots = []; $daySlots = [];

        foreach ($grades as $tgrade) {
            foreach ($tdays as $tday) {
                foreach ($thours as $thour) {
                    $timetable = Timetable::join('timetable_teacher_subjects AS t2', 'timetables.teacher_subject_id', '=', 't2.teacher_subject_id')
                                      ->where('timetables.location_code', auth()->user()->work_place->location_code)
                                      ->where('timetables.academic_id', $academicYear->year_id)
                                      ->where('timetables.tgrade_id', $tgrade->tgrade_id)
                                      ->where('timetables.day_id', $tday->day_id)
                                      ->where('timetables.hour_id', $thour->hour_id)
                                      ->select('t2.teacher_subject')
                                      ->first();
                    
                    $hourSlots[] = $timetable;
                }
                $daySlots[] = $hourSlots;
                $hourSlots = [];
            }
            $timetables[] = $daySlots;
            $daySlots = [];
        }

        //return $timetables[0][0][1];

        return view('admin.timetables.prints.teacher_student', compact(
                'academicYear', 'userWorkplace', 'tdays', 'thours', 'grades', 'timetables'
            ));
    }

    // All teachers timetable
    public function printBulkTeacherTimetable()
    {
        if (request()->search) {
            $academicYear = AcademicYear::where('year_id', request()->academic_id)->select('year_id', 'year_kh')->first();
        } else {
            $academicYear = AcademicYear::where('cur_year', 1)->select('year_id', 'year_kh')->first();
        }

        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', auth()->user()->work_place->location_code)->select($locationSelectQuery)->first();

        if ($userLocation->location_type_id == 18) { $schoolLevel = 1; }
        elseif ($userLocation->location_type_id == 11 || $userLocation->location_type_id == 17) { $schoolLevel = 2; }
        else { $schoolLevel = 3; }

        $userWorkplace = Location::where('location_code', auth()->user()->work_place->location_code)
                                 ->select('location_code', 'location_kh')
                                 ->first();

        // Days & Hours
        $tdays = DayTeaching::orderBy('day_order', 'ASC')->take(6)->get();
        $thours = HourTeaching::where('school_level', $schoolLevel)
                              ->whereIn('hour_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
                              ->orderBy('hour_order', 'ASC')
                              ->get();

        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'position_hierarchy'];
        $staffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                        ->leftJoin('sys_positions as t3', 't2.position_id', '=', 't3.position_id')
                        ->where('t2.cur_pos', 1)
                        ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                        ->where('hrmis_staffs.is_cont_staff', 0)
                        ->where('t2.location_code', auth()->user()->work_place->location_code)
                        ->select($selectQuery)
                        ->groupBy($selectQuery)
                        ->orderBy('t3.position_hierarchy', 'ASC')
                        ->orderBy('hrmis_staffs.surname_kh', 'ASC')
                        ->orderBy('hrmis_staffs.name_kh', 'ASC')
                        ->get();

        // Get timetable
        $timetables = [];
        $hourSlots = []; $daySlots = [];

        foreach ($staffs as $staff) {
            foreach ($tdays as $tday) {
                foreach ($thours as $thour) {
                    $timetable = Timetable::join('timetable_teacher_subjects AS t2', 'timetables.teacher_subject_id', '=', 't2.teacher_subject_id')
                                          ->join('timetable_grades AS t3', 'timetables.tgrade_id', '=', 't3.tgrade_id')
                                          ->join('sys_grades AS t4', 't3.grade_id', '=', 't4.grade_id')
                                      ->where('timetables.location_code', auth()->user()->work_place->location_code)
                                      ->where('timetables.academic_id', $academicYear->year_id)
                                      ->where('t2.payroll_id', $staff->payroll_id)
                                      ->where('timetables.day_id', $tday->day_id)
                                      ->where('timetables.hour_id', $thour->hour_id)
                                      ->select('t4.grade_kh', 't3.grade_name')
                                      ->first();
                    
                    $hourSlots[] = $timetable;
                }
                $daySlots[] = $hourSlots;
                $hourSlots = [];
            }
            $timetables[] = $daySlots;
            $daySlots = [];
        }

        return view('admin.timetables.prints.teacher_bulk', compact(
                'academicYear', 'userWorkplace', 'tdays', 'thours', 'staffs', 'timetables'
            ));
    }
}
