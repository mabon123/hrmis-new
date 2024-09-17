<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\CPD\Course;
use App\Models\CPD\CourseAudience;
//use App\Models\CPD\FieldOfStudy;
use App\Models\CPD\LearningOption;
use App\Models\CPD\Provider;
use App\Models\CPD\ScheduleCourse;
//use App\Models\CPD\SubjectOfStudy;
use App\Models\CPD\TeacherEducator;
use App\Models\District;
use App\Models\Position;
use App\Models\Province;
use App\Models\QualificationCode;
use App\Models\TrainingPartnerType;

class CPDScheduleCourseController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-cpd-schedule-course', ['only' => ['index']]);
        $this->middleware('permission:create-cpd-schedule-course', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-cpd-schedule-course', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-cpd-schedule-course', ['only' => ['destroy']]);
    }

    // Listing
    public function index()
    {
        $scheduleCourses = ScheduleCourse::when(auth()->user()->hasRole('cpd_provider'), function ($query) {
            $query->where('provider_id', auth()->user()->provider_id);
        })
            ->paginate(10);

        return view('admin.cpd_tcp.schedule_courses.index', compact('scheduleCourses'));
    }

    // Create
    public function create()
    {
        $courses = Course::active()
            ->when(auth()->user()->hasRole('cpd_provider'), function ($query) {
                $query->join('cpd_course_providers', 'cpd_courses.cpd_course_id', '=', 'cpd_course_providers.cpd_course_id');
                $query->where('cpd_course_providers.provider_id', auth()->user()->provider_id);
            })
            ->get()
            ->pluck('full_course', 'cpd_course_id')->all();

        $learningOptions = LearningOption::pluck('learning_option_kh', 'learning_option_id')->all();

        // If CPD Provider login
        if (auth()->user()->hasRole('cpd_provider')) {
            $providers = Provider::where('provider_id', auth()->user()->provider_id)
                ->pluck('provider_kh', 'provider_id')->all();
        } else {
            $providers = Provider::pluck('provider_kh', 'provider_id')->all();
            $providers = ['' => __('common.choose') . ' ...'] + $providers;
        }

        $teacherEducators = TeacherEducator::join(
            'hrmis_staffs as tstaff',
            'cpd_teacher_educators.payroll_id',
            '=',
            'tstaff.payroll_id'
        )
            ->select(DB::raw('CONCAT(tstaff.surname_kh, \' \', tstaff.name_kh) AS fullname_kh'), 'teacher_educator_id')
            ->pluck('fullname_kh', 'teacher_educator_id')
            ->all();

        $qualifications = QualificationCode::where('cpd_schedule_course', 1)
            ->orderBy('qualification_hierachy', 'ASC')
            ->pluck('qualification_kh', 'qualification_code')
            ->all();

        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $districts = [];
        $partners = TrainingPartnerType::active()->pluck('partner_type_kh', 'partner_type_id')->all();
        $positions = Position::orderBy('position_hierarchy', 'desc')
            ->pluck('position_kh', 'position_id')
            ->all();

        return view('admin.cpd_tcp.schedule_courses.create', compact(
            'courses',
            'learningOptions',
            'teacherEducators',
            'providers',
            'qualifications',
            'provinces',
            'partners',
            'positions',
            'districts'
        ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'cpd_course_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'learning_option_id' => 'required',
            'partner_type_id' => 'required',
            'provider_id' => 'required',
            'participant_num' => 'required',
            'qualification_code' => 'required'
        ]);

        $is_mobile = false;

        $errors = [];

        if ($request->is_mobile) {
            // Validate if registration_start_date > registration_end_date
            $reg_start_date = Carbon::createFromFormat('d-m-Y', $request->reg_start_date);
            $reg_end_date = Carbon::createFromFormat('d-m-Y', $request->reg_end_date);

            if ($reg_start_date->gt($reg_end_date)) {
                $errors += ['reg_date_error' => __('validation.gte_reg_start_date')];
            }
            $is_mobile = $request->is_mobile;
        }

        // Validate if start_date > end_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);

        if ($start_date->gt($end_date)) {
            $errors += ['date_error' => __('validation.gte_start_date')];
        }

        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        // Pro_code required if course is not online
        if ($request->learning_option_id > 1) {
            $request->validate([
                'pro_code' => 'required',
            ]);
        }

        $scheduleCourse = ScheduleCourse::create([
            'is_mobile' => auth()->user()->hasRole('cpd_provider') ? true : $is_mobile,
            'cpd_course_id' => $request->cpd_course_id,
            'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
            'participant_num' => $request->participant_num ? $request->participant_num : null,
            'reg_start_date' => date('Y-m-d', strtotime($is_mobile ? $request->reg_start_date : $request->start_date)),
            'reg_end_date' => date('Y-m-d', strtotime($is_mobile ? $request->reg_end_date : $request->end_date)),
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'partner_type_id' => $request->partner_type_id,
            'provider_id' => $request->provider_id,
            'teacher_educator_id' => $request->teacher_educator_id ? $request->teacher_educator_id : null,
            'course_status' => 1,
            'learning_option_id' => $request->learning_option_id,
            'pro_code' => $request->pro_code ? $request->pro_code : null,
            'dis_code' => $request->dis_code ? $request->dis_code : null,
            'address' => $request->address,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        // Store course audience
        foreach ($request->target_audiences as $target_audience) {
            CourseAudience::create([
                'schedule_course_id' => $scheduleCourse->schedule_course_id,
                'position_id' => $target_audience,
            ]);
        }

        return redirect()->route('cpd-schedule-courses.index', app()->getLocale())
            ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(ScheduleCourse $cpd_schedule_course)
    {
        $headerid = $cpd_schedule_course->schedule_course_id;
        $cpd_schedule_course->reg_start_date = date('d-m-Y', strtotime($cpd_schedule_course->reg_start_date));
        $cpd_schedule_course->reg_end_date = date('d-m-Y', strtotime($cpd_schedule_course->reg_end_date));
        $cpd_schedule_course->start_date = date('d-m-Y', strtotime($cpd_schedule_course->start_date));
        $cpd_schedule_course->end_date = date('d-m-Y', strtotime($cpd_schedule_course->end_date));

        //$courses = Course::active()->get()->pluck('full_course', 'cpd_course_id')->all();
        $courses = Course::active()
            ->when(auth()->user()->hasRole('cpd_provider'), function ($query) {
                $query->join('cpd_course_providers', 'cpd_courses.cpd_course_id', '=', 'cpd_course_providers.cpd_course_id');
                $query->where('cpd_course_providers.provider_id', auth()->user()->provider_id);
            })
            ->get()
            ->pluck('full_course', 'cpd_course_id')
            ->all();

        $learningOptions = LearningOption::pluck('learning_option_kh', 'learning_option_id')->all();

        //$providers = Provider::pluck('provider_kh', 'provider_id')->all();
        // If CPD Provider login
        if (auth()->user()->hasRole('cpd_provider')) {
            $providers = Provider::where('provider_id', auth()->user()->provider_id)
                ->pluck('provider_kh', 'provider_id')->all();
        } else {
            $providers = Provider::pluck('provider_kh', 'provider_id')->all();
            $providers = ['' => __('common.choose') . ' ...'] + $providers;
        }

        $teacherEducators = TeacherEducator::join(
            'hrmis_staffs as tstaff',
            'cpd_teacher_educators.payroll_id',
            '=',
            'tstaff.payroll_id'
        )
            ->select(DB::raw('CONCAT(tstaff.surname_kh, \' \', tstaff.name_kh) AS fullname_kh'), 'teacher_educator_id')
            ->pluck('fullname_kh', 'teacher_educator_id')
            ->all();

        $qualifications = QualificationCode::where('cpd_schedule_course', 1)
            ->orderBy('qualification_hierachy', 'ASC')
            ->pluck('qualification_kh', 'qualification_code')
            ->all();

        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();
        $partners = TrainingPartnerType::active()->pluck('partner_type_kh', 'partner_type_id')->all();
        $positions = Position::orderBy('position_hierarchy', 'desc')
            ->pluck('position_kh', 'position_id')
            ->all();

        // Target audiences
        $audiences = CourseAudience::where('schedule_course_id', $cpd_schedule_course->schedule_course_id)
            ->pluck('position_id')
            ->all();

        $districts = [];
        if (!empty($cpd_schedule_course->pro_code)) {
            $districts = District::whereProCode($cpd_schedule_course->pro_code)
                ->pluck('name_kh', 'dis_code')
                ->all();
        }

        return view('admin.cpd_tcp.schedule_courses.create', compact(
            'courses',
            'learningOptions',
            'teacherEducators',
            'providers',
            'qualifications',
            'provinces',
            'partners',
            'positions',
            'districts',
            'headerid',
            'cpd_schedule_course',
            'audiences'
        ));
    }

    // Update
    public function update(Request $request, ScheduleCourse $cpd_schedule_course)
    {
        $request->validate([
            'cpd_course_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'learning_option_id' => 'required',
            'partner_type_id' => 'required',
            'provider_id' => 'required',
            'participant_num' => 'required',
            'qualification_code' => 'required'
        ]);

        $is_mobile = false;

        $errors = [];

        if ($request->is_mobile) {
            // Validate if registration_start_date > registration_end_date
            $reg_start_date = Carbon::createFromFormat('d-m-Y', $request->reg_start_date);
            $reg_end_date = Carbon::createFromFormat('d-m-Y', $request->reg_end_date);

            if ($reg_start_date->gt($reg_end_date)) {
                $errors += ['reg_date_error' => __('validation.gte_reg_start_date')];
            }
            $is_mobile = $request->is_mobile;
        }
        // Validate if start_date > end_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);

        if ($start_date->gt($end_date)) {
            $errors += ['date_error' => __('validation.gte_start_date')];
        }

        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        // Pro_code required if course is not online
        if ($request->learning_option_id > 1) {
            $request->validate([
                'pro_code' => 'required',
            ]);
        }
        $cpd_schedule_course->fill([
            'is_mobile' => auth()->user()->hasRole('cpd_provider') ? true : $is_mobile,
            'cpd_course_id' => $request->cpd_course_id,
            'qualification_code' => $request->qualification_code ? $request->qualification_code : null,
            'participant_num' => $request->participant_num ? $request->participant_num : null,
            'reg_start_date' => date('Y-m-d', strtotime($is_mobile ? $request->reg_start_date : $request->start_date)),
            'reg_end_date' => date('Y-m-d', strtotime($is_mobile ? $request->reg_end_date : $request->end_date)),
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'partner_type_id' => $request->partner_type_id,
            'provider_id' => $request->provider_id,
            'teacher_educator_id' => $request->teacher_educator_id ? $request->teacher_educator_id : null,
            'course_status' => 1,
            'learning_option_id' => $request->learning_option_id,
            'pro_code' => $request->pro_code ? $request->pro_code : null,
            'dis_code' => $request->dis_code ? $request->dis_code : null,
            'address' => $request->address,
            'updated_by' => auth()->user()->id,
        ])->save();

        // Remove non-existing old target_audiences
        CourseAudience::where('schedule_course_id', $cpd_schedule_course->schedule_course_id)
            ->whereNotIn('position_id', $request->target_audiences)
            ->delete();

        // Find left target_audiences
        $leftAudiences = CourseAudience::where('schedule_course_id', $cpd_schedule_course->schedule_course_id)
            ->pluck('position_id')
            ->all();

        // Find new target_audiences
        $newAudiences = array_diff($request->target_audiences, $leftAudiences);

        // Store course audience
        foreach ($newAudiences as $target_audience) {
            CourseAudience::create([
                'schedule_course_id' => $cpd_schedule_course->schedule_course_id,
                'position_id' => $target_audience,
            ]);
        }

        return redirect()->route('cpd-schedule-courses.index', app()->getLocale())
            ->withSuccess(__('validation.add_success'));
    }

    // Delete
    public function destroy(ScheduleCourse $cpd_schedule_course)
    {
        // Remove target_audiences
        $cpd_schedule_course->targetAudiences()->delete();

        //Remove enrollment courses
        $cpd_schedule_course->enrollmentCourses()->delete();

        // Remove cpd_schedule_course
        $cpd_schedule_course->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
