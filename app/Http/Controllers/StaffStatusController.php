<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\StaffStatus;

class StaffStatusController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:administrator');
        //$this->middleware('permission:view-staff-status', ['only' => ['index']]);
        //$this->middleware('permission:create-staff-status', ['only' => ['create', 'store']]);
        //$this->middleware('permission:edit-staff-status', ['only' => ['edit', 'update']]);
        //$this->middleware('permission:delete-staff-status', ['only' => ['destroy']]);
    }


    /**
     * Staff status listing
     */
    public function index()
    {
    	$staffStatus = StaffStatus::orderBy('status_id', 'ASC')->paginate(10);

    	return view('admin.staff_status.index', compact('staffStatus'));
    }


    /**
     * Store staff status info
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'status_kh' => 'required',
    	]);

    	// Get last staff status
    	$existStatus = StaffStatus::latest('status_id')->first();

    	$statusData = $request->all();
    	$statusData['status_id'] = $existStatus ? $existStatus->status_id + 1 : 1;

    	StaffStatus::create($statusData);

    	return redirect()->back()->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing staff status
     *
     * @param  Object  StaffStatus  $staff_status
     */
    public function edit(StaffStatus $staff_status)
    {
    	return $staff_status;
    }


    /**
     * Update existing staff status info
     *
     * @param  Object  StaffStatus  $staff_status
     */
    public function update(Request $request, StaffStatus $staff_status)
    {
    	$request->validate([
    		'status_kh' => 'required',
    	]);

    	$staff_status->fill($request->all())->save();

    	return redirect()->back()->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing staff status info
     *
     * @param  Object  StaffStatus  $staff_status
     */
    public function destroy(StaffStatus $staff_status)
    {
    	$staff_status->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
