<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Staff;
use App\Models\StaffFamily;

class ChildrenController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    /**
     * Store children information
     *
     * @param  Staff  $staff
     */
    public function store(Staff $staff, Request $request)
    {
    	// Get total number of child
    	$totalChild = StaffFamily::where('payroll_id', $staff->payroll_id)
    							 ->whereIn('relation_type_id', [3])
    							 ->count();

    	$childData['payroll_id'] 		= $staff->payroll_id;
    	$childData['relation_type_id'] 	= 3;
    	$childData['fullname_kh'] 		= $request->fullname_kh;
    	$childData['dob'] 				= $request->dob > 0 ? date('Y-m-d', strtotime($request->dob)) : null;
    	$childData['gender'] 			= $request->gender;
    	$childData['occupation'] 		= $request->occupation;
    	$childData['spouse_workplace'] 	= null;
    	$childData['allowance'] 		= $request->allowance;
    	$childData['created_by'] 		= Auth::user()->id;
    	$childData['updated_by'] 		= Auth::user()->id;

    	$familyInfo = StaffFamily::create($childData);

    	$familyInfo->total_child = $totalChild;

    	return $familyInfo;
    }


    /**
     * Edit children information
     *
     * @param  Object Staff  $staff
     * @param  Object StaffFamily  $children
     */
    public function edit(Staff $staff, StaffFamily $children)
    {
    	$children->dob = date('d-m-Y', strtotime($children->dob));

    	return $children;
    }


    /**
     * Update children info
     *
     * @param  Object Staff  $staff
     * @param  Object StaffFamily  $children
     */
    public function update(Staff $staff, StaffFamily $children, Request $request)
    {
    	$childData = $request->all();

    	$childData['dob']  		 = $request->dob > 0 ? date('Y-m-d', strtotime($request->dob)) : null;
        $childData['allowance']  = $request->allowance ? 1 : 0;
        $childData['updated_by'] = Auth::user()->id;

        $children->fill($childData)->save();

        return redirect()->route('families.index', [app()->getLocale(), $staff->payroll_id])
                         ->with('success', __('validation.update_success'));
    }


    /**
     * Remove children info
     *
     * @param  Object Staff  $staff
     * @param  Object StaffFamily  $children
     */
    public function destroy(Staff $staff, StaffFamily $children)
    {
    	$children->delete();

    	return redirect()->route('families.index', [app()->getLocale(), $staff->payroll_id])
            ->withSuccess(__('validation.delete_success'));
    }
}
