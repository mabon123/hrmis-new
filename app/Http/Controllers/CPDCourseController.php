<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CPD\CourseRelation;
use App\Models\CPD\CourseType;
use App\Models\CPD\Course;
use App\Models\CPD\FieldOfStudy;
use App\Models\CPD\Provider;
use App\Models\CPD\SubjectOfStudy;

class CPDCourseController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('role:administrator');
    }

    // Listing
    public function index()
    {
        $courses = Course::paginate(20);

        return view('admin.cpd_tcp.cpd_courses.index', compact('courses'));
    }

    // Create
    public function create()
    {
        $courseTypes = CourseType::pluck('cpd_course_type_kh', 'cpd_course_type_id')->all();
        $fieldOfStudies = FieldOfStudy::active()->get()->pluck('field_code_kh', 'cpd_field_id')->all();
        $subjectOfStudies = SubjectOfStudy::active()->get()->pluck('subject_code_kh', 'cpd_subject_id')->all();
        $providers = Provider::pluck('provider_kh', 'provider_id')->all();
        
    	return view('admin.cpd_tcp.cpd_courses.create', compact(
            'courseTypes', 'fieldOfStudies', 'subjectOfStudies', 'providers'
        ));
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'cpd_course_code' => 'required|max:10',
            'cpd_course_kh' => 'required',
            'cpd_course_type_id' => 'required',
            'duration_hour' => 'required',
            'credits' => 'required',
            'cpd_course_desc_kh' => 'required',
            'cpd_field_id_1' => 'required',
            'cpd_subject_id_1' => 'required',
            //'provider_id' => 'required',
        ]);

        $CPDOffering = Course::create([
            'cpd_course_code' => $request->cpd_course_code,
            //'provider_id' => $request->provider_id, // Provider info
            'cpd_course_type_id' => $request->cpd_course_type_id,
            'cpd_course_kh' => $request->cpd_course_kh,
            'cpd_course_en' => $request->cpd_course_en,
            'cpd_course_desc_kh' => $request->cpd_course_desc_kh,
            'cpd_course_desc_en' => $request->cpd_course_desc_en,
            'end_date' => null,
            'credits' => $request->credits,
            'duration_hour' => $request->duration_hour,
            'active' => $request->active ? 1 : 0,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        // Insert data into cpd_course_providers table
        foreach ($request->providers as $provider_id) {
            $CPDOffering->providers()->attach($provider_id);
        }

        // Insert data into course relation
        CourseRelation::create([
            'cpd_course_id' => $CPDOffering->cpd_course_id,
            'cpd_field_id' => $request->cpd_field_id_1,
            'cpd_subject_id' => $request->cpd_subject_id_1,
        ]);

        // #2
        if (!is_null($request->cpd_field_id_2) && !is_null($request->cpd_subject_id_2)) {
            CourseRelation::create([
                'cpd_course_id' => $CPDOffering->cpd_course_id,
                'cpd_field_id' => $request->cpd_field_id_2,
                'cpd_subject_id' => $request->cpd_subject_id_2,
            ]);
        }

        // #3
        if (!is_null($request->cpd_field_id_3) && !is_null($request->cpd_subject_id_3)) {
            CourseRelation::create([
                'cpd_course_id' => $CPDOffering->cpd_course_id,
                'cpd_field_id' => $request->cpd_field_id_3,
                'cpd_subject_id' => $request->cpd_subject_id_3,
            ]);
        }

        return redirect()->route('cpd-courses.index', app()->getLocale())
                         ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit(Course $cpd_course)
    {
        $headerid = $cpd_course->cpd_course_id;
        $courseTypes = CourseType::pluck('cpd_course_type_kh', 'cpd_course_type_id')->all();
        $fieldOfStudies = FieldOfStudy::active()->get()->pluck('field_code_kh', 'cpd_field_id')->all();
        $subjectOfStudies = SubjectOfStudy::active()->get()->pluck('subject_code_kh', 'cpd_subject_id')->all();
        $providers = Provider::pluck('provider_kh', 'provider_id')->all();

        $cpd_course->end_date = date('d-m-Y', strtotime($cpd_course->end_date));

        return view('admin.cpd_tcp.cpd_courses.create', compact(
                'headerid', 'cpd_course', 'courseTypes', 'fieldOfStudies', 'subjectOfStudies',
                'providers'
            ));
    }

    // Update
    public function update(Request $request, Course $cpd_course)
    {
        $request->validate([
            'cpd_course_code' => 'required|max:10',
            'cpd_course_kh' => 'required',
            'cpd_course_type_id' => 'required',
            'duration_hour' => 'required',
            'credits' => 'required',
            'cpd_course_desc_kh' => 'required',
            'cpd_field_id_1' => 'required',
            'cpd_subject_id_1' => 'required',
            //'provider_id' => 'required',
        ]);

        $cpd_course->fill([
            'cpd_course_code' => $request->cpd_course_code,
            //'provider_id' => $request->provider_id,
            'cpd_course_type_id' => $request->cpd_course_type_id,
            'cpd_course_kh' => $request->cpd_course_kh,
            'cpd_course_en' => $request->cpd_course_en,
            'cpd_course_desc_kh' => $request->cpd_course_desc_kh,
            'cpd_course_desc_en' => $request->cpd_course_desc_en,
            'credits' => $request->credits,
            'duration_hour' => $request->duration_hour,
            'active' => $request->active ? 1 : 0,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now(),
        ])->save();

        // Delete & Insert data into cpd_course_providers table
        $cpd_course->providers()->detach();
        foreach ($request->providers as $provider_id) {
            $cpd_course->providers()->attach($provider_id);
        }

        // Remove old course relation
        CourseRelation::where('cpd_course_id', $cpd_course->cpd_course_id)->delete();

        // Insert data into course relation
        CourseRelation::create([
            'cpd_course_id' => $cpd_course->cpd_course_id,
            'cpd_field_id' => $request->cpd_field_id_1,
            'cpd_subject_id' => $request->cpd_subject_id_1,
        ]);

        // #2
        if (!is_null($request->cpd_field_id_2) && !is_null($request->cpd_subject_id_2)) {
            CourseRelation::create([
                'cpd_course_id' => $cpd_course->cpd_course_id,
                'cpd_field_id' => $request->cpd_field_id_2,
                'cpd_subject_id' => $request->cpd_subject_id_2,
            ]);
        }

        // #3
        if (!is_null($request->cpd_field_id_3) && !is_null($request->cpd_subject_id_3)) {
            CourseRelation::create([
                'cpd_course_id' => $cpd_course->cpd_course_id,
                'cpd_field_id' => $request->cpd_field_id_3,
                'cpd_subject_id' => $request->cpd_subject_id_3,
            ]);
        }

        return redirect()->route('cpd-courses.index', app()->getLocale())
                         ->withSuccess(__('validation.update_success'));
    }

    // Delete
    public function destroy(Course $cpd_course)
    {
        // Remove course relations
        $cpd_course->courseRelations()->delete();

        // Remove cpd offering
        $cpd_course->delete();

        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
