<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Location;
use App\Models\LocationHistory;
use App\Models\Position;
use App\Models\Province;
use App\Models\Staff;
use App\Models\StaffProfessional;
use App\Models\Subject;
use App\Models\TeachingSubject;
use App\Models\WorkHistory;

use App\Models\Timetables\TeacherSubject;
use App\Models\Timetables\TimetableGrade;

class StaffAllocationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-manage-staff-allocation', ['only' => ['index']]);
    }

    // Index
    public function index()
    {
        // Search
        if (request()->search) {
            $locQuery = ['location_type_id', 'multi_level_edu'];
            $location = Location::where('location_code', request()->location_code)->select($locQuery)->first();

            $isPreSchool = false; $isPriSchool = false; $isLowerSchool = false; $isUpperSchool = false;

            // Pre-school
            if ($location->location_type_id == 18) { 
                $educationLevel = [1]; 
                $isPreSchool = true;
            }

            // Primary school
            elseif ($location->location_type_id == 17 || $location->location_type_id == 11) {
                $educationLevel = $location->multi_level_edu == 1 ? [1, 2] : [2];
                $isPriSchool = true;
            }

            // Lower secondar school
            elseif ($location->location_type_id == 15 || $location->location_type_id == 10) {
                $educationLevel = [3];
                $isLowerSchool = true;
            }

            // Upper secondary school
            elseif ($location->location_type_id == 14 || $location->location_type_id == 9) {
                $educationLevel = $location->multi_level_edu >= 1 ? [3, 4] : [4];
                $isUpperSchool = true;

                $subjects = Subject::where('edu_level_id', 4)
                                   ->orderBy('subject_hierachy', 'ASC')
                                   ->get();
            }

            elseif ($location->location_type_id == 3) { 
                $educationLevel = [5]; 
            }

            else  { 
                $educationLevel = [6]; 
            }
        }

        //return $location;

        // Report #1
        if (request()->btn_student_statistic && request()->btn_student_statistic == true) {
            // Get grades by education level
            $grades = Grade::whereIn('edu_level_id', $educationLevel)->pluck('grade_kh', 'grade_id')->all();

            // School data
            $schoolData = LocationHistory::where('location_code', request()->location_code)
                                         ->where('year_id', request()->year_id)
                                         ->first();

            $upperTeacherBySubjectArrs = []; $lowerTeacherBySubjectArrs = []; 
            $upperClassInCharges = []; $lowerClassInCharges = [];

            if ($isPreSchool == true) { return 'Pre-school.....!'; }

            elseif ($isPriSchool == true) { return 'Pri-school........!'; }

            elseif ($isLowerSchool == true) { return 'Lower-school.........!'; }

            elseif ($isUpperSchool == true) {
                foreach ($subjects as $s_index => $subject) {
                    $teacherBySubjects = [];
                    $upper_g12 = 0; $upper_g9 = 0; $upper_g6 = 0; $upper_g0 = 0;
                    $upper_g12f = 0; $upper_g9f = 0; $upper_g6f = 0; $upper_g0f = 0;
                    $upper_class_incharge = 0;
                    $lower_g12 = 0; $lower_g9 = 0; $lower_g6 = 0; $lower_g0 = 0;
                    $lower_g12f = 0; $lower_g9f = 0; $lower_g6f = 0; $lower_g0f = 0;
                    $lower_class_incharge = 0;
                    $pri_g12 = 0; $pri_g9 = 0; $pri_g6 = 0; $pri_g0 = 0;
                    $pre_g12 = 0; $pre_g9 = 0; $pre_g6 = 0; $pre_g0 = 0;

                    $upperTeacherSubjects = TeacherSubject::where('location_code', request()->location_code)
                                                        ->where('subject_id', $subject->subject_id)
                                                        ->whereIn('grade_id', [10, 11, 12])
                                                        ->get();

                    $lowerTeacherSubjects = TeacherSubject::where('location_code', request()->location_code)
                                                        ->where('subject_id', $subject->subject_id)
                                                        ->whereIn('grade_id', [7, 8, 9])
                                                        ->get();

                    # Upper
                    foreach ($upperTeacherSubjects as $upperTeacherSubject) {
                        if (!empty($upperTeacherSubject->staff) && !empty($upperTeacherSubject->staff->highestPrefession[0])) {
                            if ($upperTeacherSubject->staff->highestPrefession[0]->prof_category_id == 11) {
                                $upper_g12 += 1;
                                $upper_g12f += $upperTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($upperTeacherSubject->staff->highestPrefession[0]->prof_category_id == 12) {
                                $upper_g9 += 1;
                                $upper_g9f += $upperTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($upperTeacherSubject->staff->highestPrefession[0]->prof_category_id == 13) {
                                $upper_g6 += 1;
                                $upper_g6f += $upperTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($upperTeacherSubject->staff->highestPrefession[0]->prof_category_id == 14) {
                                $upper_g0 += 1;
                                $upper_g0f += $upperTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                        }

                        $tGrade = TimetableGrade::where('payroll_id', $upperTeacherSubject->payroll_id)->whereIn('grade_id', [10, 11, 12])->first();
                        if (!empty($tGrade)) { $upper_class_incharge += 1; }
                    }

                    # Lower
                    foreach ($lowerTeacherSubjects as $lowerTeacherSubject) {
                        if (!empty($lowerTeacherSubject->staff) && !empty($lowerTeacherSubject->staff->highestPrefession[0])) {
                            if ($lowerTeacherSubject->staff->highestPrefession[0]->prof_category_id == 11) {
                                $lower_g12 += 1;
                                $lower_g12f += $lowerTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($lowerTeacherSubject->staff->highestPrefession[0]->prof_category_id == 12) {
                                $lower_g9 += 1;
                                $lower_g9f += $lowerTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($lowerTeacherSubject->staff->highestPrefession[0]->prof_category_id == 13) {
                                $lower_g6 += 1;
                                $lower_g6f += $lowerTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                            elseif ($lowerTeacherSubject->staff->highestPrefession[0]->prof_category_id == 14) {
                                $lower_g0 += 1;
                                $lower_g0f += $lowerTeacherSubject->staff->sex == 2 ? 1 : 0;
                            }
                        }

                        $tGrade = TimetableGrade::where('payroll_id', $lowerTeacherSubject->payroll_id)->whereIn('grade_id', [7, 8, 9])->first();
                        if (!empty($tGrade)) { $lower_class_incharge += 1; }
                    }

                    $upperTeacherBySubjectArrs[] = [$upper_g12, $upper_g12f, $upper_g9, $upper_g9f, $upper_g6, $upper_g6f, $upper_g0, $upper_g0f];
                    $lowerTeacherBySubjectArrs[] = [$lower_g12, $lower_g12f, $lower_g9, $lower_g9f, $lower_g6, $lower_g6f, $lower_g0, $lower_g0f];

                    $upperClassInCharges[] = $upper_class_incharge;
                    $lowerClassInCharges[] = $lower_class_incharge;
                }

                // Find school director
                $schoolDirectors = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                        ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                        ->where('t2.cur_pos', 1)
                                        ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                                        ->where('hrmis_staffs.is_cont_staff', 0)
                                        ->where('t2.location_code', request()->location_code)
                                        ->where('t2.position_id', 34)
                                        ->select('hrmis_staffs.*')
                                        ->get();

                $totalSchoolDirectorArr = [];
                $totalUpperSchoolDirector = 0; $totalLowerSchoolDirector = 0; $totalPriSchoolDirector = 0; $totalPreSchoolDirector = 0;
                $totalUpperSchoolDirectorf = 0; $totalLowerSchoolDirectorf = 0; $totalPriSchoolDirectorf = 0; $totalPreSchoolDirectorf = 0;

                foreach ($schoolDirectors as $schoolDirector) {
                    if (!empty($schoolDirector->highestPrefession[0])) {
                        if ($schoolDirector->highestPrefession[0]->prof_category_id == 11) {
                            $totalUpperSchoolDirector += 1;
                            $totalUpperSchoolDirectorf += $schoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($schoolDirector->highestPrefession[0]->prof_category_id == 12) {
                            $totalLowerSchoolDirector += 1;
                            $totalLowerSchoolDirectorf += $schoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($schoolDirector->highestPrefession[0]->prof_category_id == 13) {
                            $totalPriSchoolDirector += 1;
                            $totalPriSchoolDirectorf += $schoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($schoolDirector->highestPrefession[0]->prof_category_id == 14) {
                            $totalPreSchoolDirector += 1;
                            $totalPreSchoolDirectorf += $schoolDirector->sex == 2 ? 1 : 0;
                        }
                    }
                }

                $totalSchoolDirectorArr[] = [
                        $totalUpperSchoolDirector, $totalLowerSchoolDirector, $totalPriSchoolDirector, $totalPreSchoolDirector, 0, 0, 
                        $totalUpperSchoolDirectorf, $totalLowerSchoolDirectorf, $totalPriSchoolDirectorf, $totalPreSchoolDirectorf
                    ];

                // Deputy
                $deputySchoolDirectors = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                            ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                            ->where('t2.cur_pos', 1)
                                            ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                                            ->where('hrmis_staffs.is_cont_staff', 0)
                                            ->where('t2.location_code', request()->location_code)
                                            ->where('t2.position_id', 35)
                                            ->select('hrmis_staffs.*')
                                            ->get();

                $totalUpperDSchoolDirector = 0; $totalLowerDSchoolDirector = 0; $totalPriDSchoolDirector = 0; $totalPreDSchoolDirector = 0;
                $totalUpperDSchoolDirectorf = 0; $totalLowerDSchoolDirectorf = 0; $totalPriDSchoolDirectorf = 0; $totalPreDSchoolDirectorf = 0;

                foreach ($deputySchoolDirectors as $deputySchoolDirector) {
                    if (!empty($deputySchoolDirector->highestPrefession[0])) {
                        if ($deputySchoolDirector->highestPrefession[0]->prof_category_id == 11) {
                            $totalUpperDSchoolDirector += 1;
                            $totalUpperDSchoolDirectorf += $deputySchoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($deputySchoolDirector->highestPrefession[0]->prof_category_id == 12) {
                            $totalLowerDSchoolDirector += 1;
                            $totalLowerDSchoolDirectorf += $deputySchoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($deputySchoolDirector->highestPrefession[0]->prof_category_id == 13) {
                            $totalPriDSchoolDirector += 1;
                            $totalPriDSchoolDirectorf += $deputySchoolDirector->sex == 2 ? 1 : 0;
                        }
                        elseif ($deputySchoolDirector->highestPrefession[0]->prof_category_id == 14) {
                            $totalPreDSchoolDirector += 1;
                            $totalPreDSchoolDirectorf += $deputySchoolDirector->sex == 2 ? 1 : 0;
                        }
                    }
                }

                $totalSchoolDirectorArr[] = [
                        $totalUpperDSchoolDirector, $totalLowerDSchoolDirector, $totalPriDSchoolDirector, $totalPreDSchoolDirector, 0, 0, 
                        $totalUpperDSchoolDirectorf, $totalLowerDSchoolDirectorf, $totalPriDSchoolDirectorf, $totalPreDSchoolDirectorf
                    ];

                // Secretry
                $secretaryStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                            ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                            ->where('t2.cur_pos', 1)
                                            ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                                            ->where('hrmis_staffs.is_cont_staff', 0)
                                            ->where('t2.location_code', request()->location_code)
                                            ->where('t2.position_id', 30)
                                            ->select('hrmis_staffs.*')
                                            ->get();

                $totalUpperSecretry = 0; $totalLowerSecretry = 0; $totalPriSecretry = 0; $totalPreSecretry = 0;
                $totalUpperSecretryf = 0; $totalLowerSecretryf = 0; $totalPriSecretryf = 0; $totalPreSecretryf = 0;

                foreach ($secretaryStaffs as $secretaryStaff) {
                    if (!empty($secretaryStaff->highestPrefession[0])) {
                        if ($secretaryStaff->highestPrefession[0]->prof_category_id == 11) {
                            $totalUpperSecretry += 1;
                            $totalUpperSecretryf += $secretaryStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($secretaryStaff->highestPrefession[0]->prof_category_id == 12) {
                            $totalLowerSecretry += 1;
                            $totalLowerSecretryf += $secretaryStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($secretaryStaff->highestPrefession[0]->prof_category_id == 13) {
                            $totalPriSecretry += 1;
                            $totalPriSecretryf += $secretaryStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($secretaryStaff->highestPrefession[0]->prof_category_id == 14) {
                            $totalPreSecretry += 1;
                            $totalPreSecretryf += $secretaryStaff->sex == 2 ? 1 : 0;
                        }
                    }
                }

                $totalSchoolDirectorArr[] = [
                        $totalUpperSecretry, $totalLowerSecretry, $totalPriSecretry, $totalPreSecretry, 0, 0, 
                        $totalUpperSecretryf, $totalLowerSecretryf, $totalPriSecretryf, $totalPreSecretryf
                    ];
                
                // Librarian
                $librarianStaffs = Staff::join('hrmis_work_histories as t2', 'hrmis_staffs.payroll_id', '=', 't2.payroll_id')
                                            ->leftJoin('sys_positions as t4', 't2.position_id', '=', 't4.position_id')
                                            ->where('t2.cur_pos', 1)
                                            ->whereIn('hrmis_staffs.staff_status_id', [1, 2, 7, 8, 10])
                                            ->where('hrmis_staffs.is_cont_staff', 0)
                                            ->where('t2.location_code', request()->location_code)
                                            ->where('t2.position_id', 97)
                                            ->select('hrmis_staffs.*')
                                            ->get();

                $totalUpperLibrarian = 0; $totalLowerLibrarian = 0; $totalPriLibrarian = 0; $totalPreLibrarian = 0;
                $totalUpperLibrarianf = 0; $totalLowerLibrarianf = 0; $totalPriLibrarianf = 0; $totalPreLibrarianf = 0;

                foreach ($librarianStaffs as $librarianStaff) {
                    if (!empty($librarianStaff->highestPrefession[0])) {
                        if ($librarianStaff->highestPrefession[0]->prof_category_id == 11) {
                            $totalUpperLibrarian += 1;
                            $totalUpperLibrarianf += $librarianStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($librarianStaff->highestPrefession[0]->prof_category_id == 12) {
                            $totalLowerLibrarian += 1;
                            $totalLowerLibrarianf += $librarianStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($librarianStaff->highestPrefession[0]->prof_category_id == 13) {
                            $totalPriLibrarian += 1;
                            $totalPriLibrarianf += $librarianStaff->sex == 2 ? 1 : 0;
                        }
                        elseif ($librarianStaff->highestPrefession[0]->prof_category_id == 14) {
                            $totalPreLibrarian += 1;
                            $totalPreLibrarianf += $librarianStaff->sex == 2 ? 1 : 0;
                        }
                    }
                }

                $totalSchoolDirectorArr[] = [
                        $totalUpperLibrarian, $totalUpperLibrarianf, $totalLowerLibrarian, $totalLowerLibrarianf, 0, 0, 
                        $totalPriLibrarian, $totalPriLibrarianf, $totalPreLibrarian, $totalPreLibrarianf
                    ];

                $totalSchoolDirectorArr[] = [9, 9, 9, 9, 0, 0, 0, 0, 0, 0];
                $totalSchoolDirectorArr[] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $totalSchoolDirectorArr[] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $totalSchoolDirectorArr[] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $totalSchoolDirectorArr[] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                $totalSchoolDirectorArr[] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            }
            
            //return $totalSchoolDirectorArr;
            
            return view('admin.staff_allocations.index', compact(
                'grades', 'schoolData', 'location', 'subjects', 
                'upperTeacherBySubjectArrs', 'lowerTeacherBySubjectArrs', 
                'upperClassInCharges', 'lowerClassInCharges', 
                'totalSchoolDirectorArr'
            ));
        }

        else {
            $curAcademicYear = AcademicYear::current()->first();
            $academicYears = AcademicYear::where('year_id', '>=', $curAcademicYear->year_id)->pluck('year_kh', 'year_id')->all();
            $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        }
        
        return view('admin.staff_allocations.index', compact('curAcademicYear', 'academicYears', 'provinces'));
    }
}
