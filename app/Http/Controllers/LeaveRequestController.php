<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\StaffLeave;
use App\Models\WorkHistory;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:edit-staffs', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }
    public function index()
    {
        $curWorkPlace = auth()->user()->work_place;
        $location_code = $curWorkPlace->location_code;
        $leave_requests = StaffLeave::join('hrmis_work_histories as wh', 'hrmis_staff_leaves.payroll_id', '=', 'wh.payroll_id')
            ->select('hrmis_staff_leaves.*')
            ->where('cur_pos', 1)
            ->where('location_code', $location_code)
            ->where('leave_type_id', 2)
            ->where('app_request', 1)
            ->where(DB::raw("IFNULL(hrmis_staff_leaves.check_status_id, 0)"), 4)
            ->orderBy('hrmis_staff_leaves.start_date')
            ->limit(2)->get();

        return view('admin.leave-requests.index', compact('leave_requests'));
    }

    public function approveReject(Request $request)
    {
        $curWorkPlace = auth()->user()->work_place;
        $location_code = $curWorkPlace->location_code;

        $approve_ids = $request->approve_ids;
        $reject_ids = $request->reject_ids;
        $reject_notes = $request->reject_notes;

        if (!empty($approve_ids) && count($approve_ids) > 0) {
            for ($i = 0; $i < count($approve_ids); $i++) {
                $update_row = array(
                    'check_status_id'           => 5,
                    'supervisor_payroll'        => auth()->user()->payroll_id,
                    'updated_by'                => auth()->user()->id
                );
                StaffLeave::where('leave_id', $approve_ids[$i])->update($update_row);
            }
        }
        if (!empty($reject_ids) && count($reject_ids) > 0) {
            for ($i = 0; $i < count($reject_ids); $i++) {
                $update_row = array(
                    'check_status_id'           => 6, //Rejected
                    'supervisor_payroll'        => auth()->user()->payroll_id,
                    'reject_reason'             => $reject_notes[$i],
                    'updated_by'                => auth()->user()->id
                );
                StaffLeave::where('leave_id', $reject_ids[$i])->update($update_row);
            }
        }
        $appraisals = StaffLeave::join('sys_leave_types as t2', 'hrmis_staff_leaves.leave_type_id', '=', 't2.leave_type_id')
            ->join('hrmis_staffs', 'hrmis_staff_leaves.payroll_id', '=', 'hrmis_staffs.payroll_id')
            ->join('hrmis_work_histories as wh', 'hrmis_staff_leaves.payroll_id', '=', 'wh.payroll_id')
            ->leftJoin('sys_check_status as t3', 'hrmis_staff_leaves.check_status_id', '=', 't3.check_status_id')
            ->select(
                'hrmis_staff_leaves.leave_id',
                'hrmis_staff_leaves.payroll_id',
                'surname_kh',
                'name_kh',
                DB::raw("CASE WHEN sex=1 THEN 'ប្រុស' ELSE 'ស្រី' END as sex"),
                't2.leave_type_kh as leave_type',
                'hrmis_staff_leaves.description',
                'hrmis_staff_leaves.start_date',
                'hrmis_staff_leaves.end_date',
                DB::raw("DATE_FORMAT(hrmis_staff_leaves.start_date, '%d-%m-%Y') as start_date2"),
                DB::raw("DATE_FORMAT(hrmis_staff_leaves.end_date, '%d-%m-%Y') as end_date2"),
                'hrmis_staff_leaves.check_status_id',
                't3.check_status_kh as check_status',
                'hrmis_staff_leaves.supervisor_payroll',
                'hrmis_staff_leaves.reject_reason'
            )
            ->where('cur_pos', 1)
            ->where('location_code', $location_code)
            ->where('hrmis_staff_leaves.leave_type_id', 2)
            ->where('app_request', 1)
            ->where(DB::raw("IFNULL(hrmis_staff_leaves.check_status_id, 0)"), 4)
            ->orderBy('hrmis_staff_leaves.start_date')
            ->get()->all();
        return response($appraisals, 200);
    }
}
