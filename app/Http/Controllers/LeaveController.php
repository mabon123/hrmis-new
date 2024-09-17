<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\StaffLeave;
use App\Models\WorkHistory;

class LeaveController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:edit-staffs', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }


    // Store
    public function store(Request $request, Staff $staff)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
        ]);

        // Validate if start_date > end_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);

        if ($start_date->gt($end_date)) {
            return back()->withInput()->withErrors(__('validation.gte_start_date'));
        }

        // Validate if new_start_date <= old_end_date
        $lastRecord = StaffLeave::where('payroll_id', $staff->payroll_id)->latest()->first();

        if (!empty($lastRecord)) {
            $old_end_date = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($lastRecord->end_date)));
            
            if ($old_end_date->gt($start_date)) {
                return back()->withInput()->withErrors(__('validation.lt_date'));
            }
        }

        StaffLeave::create([
            'payroll_id' => $staff->payroll_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'description' => $request->description,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

    	return redirect()->route('work-histories.index', [app()->getLocale(), $staff->payroll_id])
    					 ->withSuccess(__('validation.add_success'));
    }

    // Edit
    public function edit($leave_id)
    {
    	$staffLeave = StaffLeave::where('leave_id', $leave_id)->first();

        $staffLeave->start_date = date('d-m-Y', strtotime($staffLeave->start_date));
        $staffLeave->end_date = date('d-m-Y', strtotime($staffLeave->end_date));

    	return $staffLeave;
    }

    // Update
    public function update($leave_id, Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
        ]);

        // Validate if start_date > end_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = $request->end_date ? Carbon::createFromFormat('d-m-Y', $request->end_date) : null;

        if ($start_date->gt($end_date)) {
            return back()->withInput()->withErrors(__('validation.gte_start_date'));
        }

        $staffLeave = StaffLeave::where('leave_id', $leave_id)->first();

        $staffLeave->fill([
            'leave_type_id' => $request->leave_type_id,
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
            'description' => $request->description,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ])->save();

        return redirect()->route('work-histories.index', [app()->getLocale(), $staffLeave->payroll_id])
                         ->withSuccess(__('validation.update_success'));
    }

    // Destroy
    public function destroy($leave_id)
    {
    	$staffLeave = StaffLeave::where('leave_id', $leave_id)->first();
    	
    	$staffLeave->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
