<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Staff;
use App\Models\StaffLanguage;

class StaffLanguageController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    /**
     * Store language info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
    	$languageData = $request->all();

    	$cur_WorkHistory = $staff->workHistories->where('cur_pos', 1)->first();

        $languageData['payroll_id'] = $staff->payroll_id;
        $languageData['pro_code']   = $cur_WorkHistory->pro_code;
        $languageData['created_by'] = Auth::user()->id;
        $languageData['updated_by'] = Auth::user()->id;

       	StaffLanguage::create($languageData);

        return redirect()->route('shortcourses.index', [app()->getLocale(), $staff->payroll_id])
                         ->with('success', 'Language has beeen created successfully.');
    }


    /**
     * Edit language info
     *
     * @param  number  $payroll_id
     * @param  Object ShortCourse  $staff_language
     */
    public function edit($payroll_id, StaffLanguage $staff_language)
    {
    	return $staff_language;
    }


    /**
     * Update language info
     *
     * @param  number  $payroll_id
     * @param  Object StaffLanguage  $staff_language
     */
    public function update($payroll_id, StaffLanguage $staff_language, Request $request)
    {
    	$languageData = $request->all();

    	$languageData['updated_by'] = Auth::user()->id;

        $staff_language->fill($languageData)->save();

        return redirect()->route('shortcourses.index', [app()->getLocale(), $payroll_id])
                         ->with('success', 'Short course has beeen updated successfully.');
    }


    /**
     * Remove language info
     *
     * @param  number  $payroll_id
     * @param  Object StaffLanguage  $language
     */
    public function destroy($payroll_id, StaffLanguage $staff_language)
    {
    	$staff_language->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
