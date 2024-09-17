<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use App\Models\DurationType;
use App\Models\Language;
use App\Models\ShortCourse;
use App\Models\ShortCourseCategory;
use App\Models\Staff;
use App\Models\StaffLanguage;
use App\Models\TrainingPartnerType;

class ShortCourseController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
    }


    /**
     * List qualification info belong to a staff
     *
     * @param  Object  Staff  $staff
     */
    public function index(Staff $staff)
    {
    	$headerid = $staff->payroll_id;

    	$shortCourseCats = ShortCourseCategory::all();

    	$durationTypes = DurationType::all();

    	$trainingPartnerTypes = TrainingPartnerType::all();

    	$languages = Language::all();

    	$shortCourses = ShortCourse::where('payroll_id', $staff->payroll_id)->latest('shortcourse_id')->get();

    	$staffLanguages = StaffLanguage::where('payroll_id', $staff->payroll_id)->latest('staff_lang_id')->get();

    	return view('admin.staffs.shortcourse', compact(
    			'headerid', 'staff', 'shortCourseCats', 'durationTypes', 'trainingPartnerTypes',
    			'shortCourses', 'languages', 'staffLanguages'
    		));
    }


    /**
     * Store short course info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
        $request->validate([
            'shortcourse_cat_id' => 'required',
            'qual_date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'qualification' => 'required',
            'organized' => 'required',
            'donor' => 'required',
            'duration' => 'required',
            'duration_type_id' => 'required',
        ]);

        // Check if end_date < start_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);

        if ($start_date->gt($end_date)) {
            return back()->withInput()->withErrors(__('validation.gte_start_date'));
        }

    	$shortCourseData = $request->all();

    	$cur_WorkHistory = $staff->workHistories->where('cur_pos', 1)->first();

        $shortCourseData['payroll_id'] = $staff->payroll_id;
        $shortCourseData['pro_code']   = $cur_WorkHistory->pro_code;
        $shortCourseData['qual_date']  = $request->qual_date > 0 ? date('Y-m-d', strtotime($request->qual_date)) : null;
        $shortCourseData['start_date'] = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
        $shortCourseData['end_date']   = $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null;
        $shortCourseData['created_by'] = Auth::user()->id;
        $shortCourseData['updated_by'] = Auth::user()->id;

       	ShortCourse::create($shortCourseData);

        return redirect()->route('shortcourses.index', [app()->getLocale(), $staff->payroll_id])
                         ->with('success', 'Short course has beeen created successfully.');
    }


    /**
     * Edit short course info
     *
     * @param  number  $payroll_id
     * @param  Object ShortCourse  $shortcourse
     */
    public function edit($payroll_id, ShortCourse $shortcourse)
    {
    	$shortcourse->qual_date = date('d-m-Y', strtotime($shortcourse->qual_date));
    	$shortcourse->start_date = date('d-m-Y', strtotime($shortcourse->start_date));
    	$shortcourse->end_date = date('d-m-Y', strtotime($shortcourse->end_date));

    	return $shortcourse;
    }


    /**
     * Update short course info
     *
     * @param  number  $payroll_id
     * @param  Object ShortCourse  $shortcourse
     */
    public function update($payroll_id, ShortCourse $shortcourse, Request $request)
    {
    	$shortCourseData = $request->all();

    	$shortCourseData['qual_date']  = $request->qual_date > 0 ? date('Y-m-d', strtotime($request->qual_date)) : null;
    	$shortCourseData['start_date'] = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
    	$shortCourseData['end_date']   = $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null;
        $shortCourseData['updated_by'] = Auth::user()->id;

        $shortcourse->fill($shortCourseData)->save();

        return redirect()->route('shortcourses.index', [app()->getLocale(), $payroll_id])
                         ->with('success', 'Short course has beeen updated successfully.');
    }


    /**
     * Remove short course info
     *
     * @param  number  $payroll_id
     * @param  Object ShortCourse  $shortcourse
     */
    public function destroy($payroll_id, ShortCourse $shortcourse)
    {
    	$shortcourse->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
