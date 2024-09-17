<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\ProfessionalCategory;
use App\Models\ProfessionalType;
use App\Models\Staff;
use App\Models\StaffProfessional;
use App\Models\Subject;

class QualificationController extends Controller
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

    	$professionalCats = ProfessionalCategory::orderBy('prof_hierachy', 'ASC')->get();

    	$professionalTypes = ProfessionalType::active()
    										 ->select('prof_type_id', 'prof_type_kh', 'prof_type_en')
    										 ->get();

    	$subjects = Subject::orderBy('subject_hierachy', 'ASC')
    					   ->select('subject_id', 'subject_kh', 'subject_en')
    					   ->get();

        //$schoolLocationTypes = LocationType::where('is_school', 1)->pluck('location_type_id');
        $locations = Location::whereIn('location_type_id', [5, 6, 7, 8])
                             ->pluck('location_kh', 'location_code')
                             ->all();

    	$qualifications = StaffProfessional::where('payroll_id', $staff->payroll_id)
    									   ->orderBy('prof_id', 'DESC')
    									   ->paginate(10);

        $highestQual = StaffProfessional::join('sys_professional_categories', 'hrmis_staff_professions.prof_category_id', '=', 'sys_professional_categories.prof_category_id')
                                        ->where('payroll_id', $staff->payroll_id)
                                        ->orderBy('sys_professional_categories.prof_hierachy', 'ASC')
                                        ->select('sys_professional_categories.prof_category_kh')
                                        ->first();

    	return view('admin.staffs.qualifications', compact(
    			'headerid', 'staff', 'professionalCats', 'professionalTypes','subjects',
    			'qualifications', 'highestQual', 'locations'
    		));
    }


    /**
     * Store qualification info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
        $request->validate([
            'prof_category_id' => 'required',
            'prof_date' => 'required',
            'prof_type_id' => 'required',
        ]);

    	$qualificationData = $request->all();
    	$lastWorkPlace = $staff->latestWorkPlace();

        $qualificationData['payroll_id'] = $staff->payroll_id;
        $qualificationData['pro_code']   = !empty($lastWorkPlace) ? $lastWorkPlace->pro_code : 0;
        $qualificationData['prof_date']  = $request->prof_date > 0 ? date('Y-m-d', strtotime($request->prof_date)) : null;
        $qualificationData['created_by'] = Auth::user()->id;
        $qualificationData['updated_by'] = Auth::user()->id;

        StaffProfessional::create($qualificationData);

        StaffProfessional::where('payroll_id', $staff->payroll_id)->update(['highest_profession' => 0]); 
        $dd_qualification = StaffProfessional::where('payroll_id', $staff->payroll_id)->orderBy('prof_category_id', 'ASC')->first();
        //dd($dd_qualification->qualification_code);
        $dd_qualification->update(['highest_profession' => 1]); 

        return redirect()->route('qualifications.index', [app()->getLocale(), $staff->payroll_id])
                         ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit qualification info
     *
     * @param  number  $payroll_id
     * @param  Object StaffProfessional  $qualification
     */
    public function edit($payroll_id, StaffProfessional $qualification)
    {
    	$qualification->prof_date = date('d-m-Y', strtotime($qualification->prof_date));

    	return $qualification;
    }


    /**
     * Update qualification info
     *
     * @param  number  $payroll_id
     * @param  Object StaffProfessional  $qualification
     */
    public function update($payroll_id, StaffProfessional $qualification, Request $request)
    {
    	$qualificationData = $request->all();

    	$qualificationData['prof_date']  = $request->prof_date > 0 ? date('Y-m-d', strtotime($request->prof_date)) : null;
        $qualificationData['updated_by'] = Auth::user()->id;

        $qualification->fill($qualificationData)->save();

        StaffProfessional::where('payroll_id', $payroll_id)->update(['highest_profession' => 0]); 
        $dd_qualification = StaffProfessional::where('payroll_id', $payroll_id)->orderBy('prof_category_id', 'ASC')->first();
        //dd($dd_qualification->qualification_code);
        $dd_qualification->update(['highest_profession' => 1]); 

        return redirect()->route('qualifications.index', [app()->getLocale(), $payroll_id])
                         ->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove qualification info
     *
     * @param  number  $payroll_id
     * @param  Object StaffProfessional  $qualification
     */
    public function destroy($payroll_id, StaffProfessional $qualification)
    {
    	$qualification->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }


    /**
     * Get qualification rank for requiring subject 1 & 2
     * if pro_hierachy <= 6, required atleast one subject among those
     *
     * @param  Object  ProfessionalCategory  $qualification
     */
    public function getQualificationRank(ProfessionalCategory $qualification)
    {
        return $qualification->prof_hierachy;
    }
}
