<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CPD\Course;
use App\Models\CPD\TempPosition;
use App\Models\CPD\TeacherEducator;
use App\Models\CPD\TeacherEducatorCourse;

class CPDTeacherEducatorController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        // $this->middleware('permission:view-teacher-educator', ['only' => ['index']]);
        // $this->middleware('permission:create-teacher-educator', ['only' => ['create', 'store']]);
        // $this->middleware('permission:edit-teacher-educator', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-teacher-educator', ['only' => ['destroy']]);
    }

    // Listing
    public function index()
    {
        $teacherEducators = TeacherEducator::paginate(20);

        return view('admin.cpd_tcp.teacher_educators.index', compact('teacherEducators'));
    }

    // Create
    public function create()
    {
        $tempPositions = TempPosition::pluck('teps_position_kh', 'teps_position_id')->all();

        $courses = Course::active()->pluck('cpd_course_kh', 'cpd_course_id')->all();

    	return view('admin.cpd_tcp.teacher_educators.create', compact(
                'tempPositions', 
                'courses'
            ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required',
            'teps_position_id' => 'required',
            'course_ids' => 'required',
        ]);

        $teacherEducator = TeacherEducator::create([
            'payroll_id' => $request->payroll_id,
            'teps_position_id' => $request->teps_position_id,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        foreach($request->course_ids as $cpd_course) {
            TeacherEducatorCourse::create([
                'teacher_educator_id' => $teacherEducator->teacher_educator_id,
                'cpd_course_id' => $cpd_course,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
        }

        return redirect()->route('cpd-teacher-educators.index', app()->getLocale())
                         ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(TeacherEducator $cpd_teacher_educator)
    {
        $headerid = $cpd_teacher_educator->teacher_educator_id;
        $tempPositions = TempPosition::pluck('teps_position_kh', 'teps_position_id')->all();
        $courses = Course::active()->pluck('cpd_course_kh', 'cpd_course_id')->all();

        $selectedCourse = TeacherEducatorCourse::where('teacher_educator_id', $headerid)
                                               ->pluck('cpd_course_id')
                                               ->all();

        return view('admin.cpd_tcp.teacher_educators.create', compact(
                'tempPositions', 'courses', 'headerid', 'selectedCourse', 
                'cpd_teacher_educator'
            ));
    }

    // Update
    public function update(Request $request, TeacherEducator $cpd_teacher_educator)
    {
        $request->validate([
            'payroll_id' => 'required',
            'teps_position_id' => 'required',
            'course_ids' => 'required',
        ]);

        $cpd_teacher_educator->fill([
            'payroll_id' => $request->payroll_id,
            'teps_position_id' => $request->teps_position_id,
            'updated_by' => auth()->user()->id,
        ])->save();

        $teacherEUDID = $cpd_teacher_educator->teacher_educator_id;
        
        // Remove non-existing old course
        TeacherEducatorCourse::where('teacher_educator_id', $teacherEUDID)
                             ->whereNotIn('cpd_course_id', $request->course_ids)
                             ->delete();

        $teacherEDUCourses = TeacherEducatorCourse::where('teacher_educator_id', $teacherEUDID)
                                                  ->pluck('cpd_course_id')
                                                  ->all();

        // Find new course
        $newEUDCourses = array_diff($request->course_ids, $teacherEDUCourses);

        foreach ($newEUDCourses as $newEUDCourse) {
            TeacherEducatorCourse::create([
                'teacher_educator_id' => $teacherEUDID,
                'cpd_course_id' => $newEUDCourse,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
        }

        return redirect()->route('cpd-teacher-educators.index', app()->getLocale())
                         ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(TeacherEducator $cpd_teacher_educator)
    {
        $cpd_teacher_educator->teacherEDUCourses()->delete();

        $cpd_teacher_educator->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
