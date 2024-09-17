<?php

namespace App\Http\Controllers\Timetables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Location;
use App\Models\Staff;
use App\Models\Timetables\TeacherPrimary;
use App\Models\Timetables\TimetableGrade;
use App\Models\Timetables\Timetable;

class TimetableGradeController extends Controller
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
        $academicYearID = request()->academic_id ? request()->academic_id : $curAcademicYear->year_id;

        $userLocationCode = auth()->user()->work_place->location_code;
        $locationSelectQuery = ['location_type_id', 'multi_level_edu'];
        $userLocation = Location::where('location_code', $userLocationCode)->select($locationSelectQuery)->first();

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

        // Set education level
        if ($userLocation->location_type_id == 18) { $educationLevel = [1]; }

        // Primary school
        elseif ($userLocation->location_type_id == 17 || $userLocation->location_type_id == 11) {
            $educationLevel = $userLocation->multi_level_edu == 1 ? [1, 2] : [2];
        }

        // Lower secondar school
        elseif ($userLocation->location_type_id == 15 || $userLocation->location_type_id == 10) {
            $educationLevel = $userLocation->multi_level_edu == 2 ? [1, 2, 3] : (
                                    $userLocation->multi_level_edu == 1 ? [2, 3] : [3]
                                );
        }

        // Upper secondary school
        elseif ($userLocation->location_type_id == 14 || $userLocation->location_type_id == 5 || $userLocation->location_type_id == 6 || $userLocation->location_type_id == 7) {
            $educationLevel = $userLocation->multi_level_edu == 3 ? [1, 2, 3, 4] : (
                                    $userLocation->multi_level_edu == 2 ? [2, 3, 4] : (
                                        $userLocation->multi_level_edu == 1 ? [3, 4] : [4]
                                    )
                                );
        }

        elseif ($userLocation->location_type_id == 3) { $educationLevel = [5]; }
        else  { $educationLevel = $userLocation->multi_level_edu == 3 ? [1, 2, 3, 4] : (
                                    $userLocation->multi_level_edu == 2 ? [2, 3, 4] : (
                                        $userLocation->multi_level_edu == 1 ? [3, 4] : [4]
                                    )
                                ); }

        $grades = Grade::whereIn('edu_level_id', $educationLevel)->pluck('grade_kh', 'grade_id')->all();

        $tgrades = TimetableGrade::where('academic_id', $academicYearID)
                                 ->where('location_code', $userLocationCode)
                                 ->when(request()->grade_id, function($query) {
                                    $query->where('grade_id', request()->grade_id);
                                 })
                                 ->orderBy('grade_id', 'ASC')
                                 ->orderBy('grade_name', 'ASC')
                                 ->paginate(20);

        return view('admin.timetables.grades.index', compact(
                'academicYears', 'curAcademicYear', 'grades', 'tgrades', 'staffs'
            ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'academic_id' => 'required',
            'grade_id' => 'required',
        ]);

        $mainGradeName = $request->grade_name[0];
        // Loop grade_name
        foreach ($request->grade_name as $gradeName) {
            $convertedGradeName = preg_match("/^[\w\d\s.,-]*$/", $gradeName) ? strtoupper($gradeName) : $gradeName;

            // Check existing grade
            $existingGrade = TimetableGrade::where('academic_id', $request->academic_id)
                                           ->where('location_code', auth()->user()->work_place->location_code)
                                           ->where('grade_id', $request->grade_id)
                                           ->where('grade_name', $convertedGradeName)
                                           ->first();

            if (!empty($mainGradeName)) {
                if ($gradeName) {
                    if (empty($existingGrade)) {
                        TimetableGrade::create([
                            'academic_id' => $request->academic_id,
                            'location_code' => auth()->user()->work_place->location_code,
                            'grade_id' => $request->grade_id,
                            'shift' => null,
                            'grade_name' => $convertedGradeName,
                            'payroll_id' => $request->payroll_id ? $request->payroll_id : null,
                        ]);
                    }
                }
            }
            else {
                if (empty($existingGrade)) {
                    TimetableGrade::create([
                        'academic_id' => $request->academic_id,
                        'location_code' => auth()->user()->work_place->location_code,
                        'grade_id' => $request->grade_id,
                        'shift' => null,
                        'grade_name' => $convertedGradeName,
                        'payroll_id' => $request->payroll_id ? $request->payroll_id : null,
                    ]);
                }
            }
        }

        return redirect()->back()->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(TimetableGrade $tgrade)
    {
        return $tgrade;
    }

    // Update
    public function update(TimetableGrade $tgrade, Request $request)
    {
        $request->validate([
            'academic_id' => 'required',
            'grade_id' => 'required',
            'grade_name' => 'required',
        ]);

        // Convert grade_name to uppercase for LATIN char
        $gradeName = $request->grade_name[0];
        $convertedGradeName = preg_match("/^[\w\d\s.,-]*$/", $gradeName) ? strtoupper($gradeName) : $gradeName;
        
        $tgrade->fill([
            'academic_id' => $request->academic_id,
            'location_code' => auth()->user()->work_place->location_code,
            'grade_id' => $request->grade_id,
            'shift' => null,
            'grade_name' => $convertedGradeName,
            'payroll_id' => $request->payroll_id ? $request->payroll_id : null,
        ])->save();

        return redirect()->back()->withSuccess(__('validation.update_success'));
    }

    // Destroy
    public function destroy(TimetableGrade $tgrade)
    {
        $timetables = Timetable::where('tgrade_id', $tgrade->tgrade_id)->delete();
        $teacherPri = TeacherPrimary::where('tgrade_id', $tgrade->tgrade_id)->delete();
        $tgrade->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
