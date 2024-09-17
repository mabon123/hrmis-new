<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
    }


    /**
     * LeaveType listing
     */
    public function index()
    {
    	$leaveTypes = LeaveType::orderBy('leave_type_id', 'ASC')->paginate(10);

    	return view('admin.leave_type.index', compact('leaveTypes'));
    }


    /**
     * Store LeaveType info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'leave_type_kh' => 'required',
    	]);

        $existLeaveType = LeaveType::latest('leave_type_id')->first();

        $leaveTypeData = $request->all();
    	$leaveTypeData['leave_type_id'] = $existLeaveType ? $existLeaveType->leave_type_id + 1 : 1;
        $leaveTypeData['active'] = $request->active ? 1 : 0;
        $leaveTypeData['created_by'] = auth()->id();
        $leaveTypeData['updated_by'] = auth()->id();
    	LeaveType::create($leaveTypeData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing LeaveType
     *
     * @param  Object  LeaveType  $leaveType
     */
    public function edit(LeaveType $leaveType)
    {
    	return $leaveType;
    }


    /**
     * Update existing LeaveType info
     *
     * @param  Object  LeaveType  $leaveType
     */
    public function update(Request $request, LeaveType $leaveType)
    {
    	$request->validate([
    		'leave_type_kh' => 'required',
    	]);

        $leaveTypeData = $request->all();
    	$leaveTypeData['active'] = $request->active ? 1 : 0;
        $leaveTypeData['updated_by'] = auth()->id();
    	$leaveType->fill($leaveTypeData)->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing LeaveType info
     *
     * @param  Object  LeaveType  $leaveType
     */
    public function destroy(LeaveType $leaveType)
    {
    	$leaveType->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
