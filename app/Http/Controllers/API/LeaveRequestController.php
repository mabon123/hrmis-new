<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\StaffLeave;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    // Get Short Leave by payroll id
    public function getShortLeavesByPayroll(Request $request)
    {
        $request->validate([
            'lang'          => 'required',
            'payroll_id'    => 'required'
        ]);
        $lang = $request->lang;
        $col_leave = 't2.leave_type_kh as leave_type';
        $col_status = 't3.check_status_kh as check_status';
        if ($lang == 'en') {
            $col_leave = 't2.leave_type_en as leave_type';
            $col_status = 't3.check_status_en as check_status';
        }
        $leaveHistory = StaffLeave::join('sys_leave_types as t2', 'hrmis_staff_leaves.leave_type_id', '=', 't2.leave_type_id')
            ->leftJoin('sys_check_status as t3', 'hrmis_staff_leaves.check_status_id', '=', 't3.check_status_id')
            ->select(
                'hrmis_staff_leaves.leave_id',
                'hrmis_staff_leaves.leave_type_id',
                $col_leave,
                'description',
                'start_date',
                'end_date',
                DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date2"),
                DB::raw("DATE_FORMAT(end_date, '%d-%m-%Y') as end_date2"),
                'hrmis_staff_leaves.check_status_id',
                $col_status,
                'hrmis_staff_leaves.supervisor_payroll',
                'hrmis_staff_leaves.reject_reason'
            )
            ->where('payroll_id', $request->payroll_id)
            ->where('hrmis_staff_leaves.leave_type_id', 2)
            ->where('app_request', 1)
            ->orderBy(DB::raw("IFNULL(hrmis_staff_leaves.check_status_id, 0)"))
            ->orderBy('start_date')
            ->get();
        $response = [
            'data'      => $leaveHistory,
            'code'      => config('constants.codes.success'),
            'message'   => $lang == 'en' ? config('constants.messages_en.request_success') : config('constants.messages.request_success')
        ];
        return response($response, 200);
    }
    //Get a leave record by leave_id
    private function getLeaveById($id, $lang)
    {
        $col_leave = 't2.leave_type_kh as leave_type';
        $col_status = 't3.check_status_kh as check_status';
        if ($lang == 'en') {
            $col_leave = 't2.leave_type_en as leave_type';
            $col_status = 't3.check_status_en as check_status';
        }

        $leave = StaffLeave::join('sys_leave_types as t2', 'hrmis_staff_leaves.leave_type_id', '=', 't2.leave_type_id')
            ->leftJoin('sys_check_status as t3', 'hrmis_staff_leaves.check_status_id', '=', 't3.check_status_id')
            ->select(
                'hrmis_staff_leaves.leave_id',
                'hrmis_staff_leaves.leave_type_id',
                $col_leave,
                'description',
                'start_date',
                'end_date',
                DB::raw("DATE_FORMAT(start_date, '%d-%m-%Y') as start_date2"),
                DB::raw("DATE_FORMAT(end_date, '%d-%m-%Y') as end_date2"),
                'hrmis_staff_leaves.check_status_id',
                $col_status,
                'hrmis_staff_leaves.supervisor_payroll',
                'hrmis_staff_leaves.reject_reason'
            )
            ->where('leave_id', $id)->first();
        return $leave;
    }

    private function checkExistingLeave($start_date, $end_date, $payroll_id = '', $leave_id = 0)
    {
        $existed_leave = StaffLeave::where(DB::raw("IFNULL(check_status_id, 0)"), '!=', 6)
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date]);
            })
            //When create new need to check with payroll_id
            ->when($payroll_id != '', function ($query) use ($payroll_id) {
                $query->where('payroll_id', $payroll_id);
            })
            //When user change requst then we need to check differnet record.
            ->when($leave_id != 0, function ($query) use ($leave_id) {
                $query->where('leave_id', '!=', $leave_id);
            })->first();
        return !empty($existed_leave) ? true : false;
    }

    public function storeLeaveRequest(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required',
            'leave_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'lang' => 'required'
        ]);
        $lang = $request->lang;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   =  date('Y-m-d', strtotime($request->end_date));

        if ($this->checkExistingLeave($start_date, $end_date, $request->payroll_id)) {
            $response = [
                'code' => config('constants.codes.fail_400'),
                'message' => $lang == 'en' ? 'You cannot request the same dates with your previous request!' : 'អ្នកបានស្នើថ្ងៃឈប់ដូចគ្នានឹងការស្នើសុំពីមុនរួចហើយ។ សូមត្រួតពិនិត្យថ្ងៃចាប់ផ្ដើម និងថ្ងៃបញ្ចប់ម្ដងទៀត!'
            ];
            return response($response, 400);
        } else {
            $leave = StaffLeave::create([
                'payroll_id'            => $request->payroll_id,
                'leave_type_id'         => $request->leave_type_id,
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'description'           => $request->description,
                'check_status_id'       => 4, //pending
                'app_request'           => 1,
                'supervisor_payroll'    => null,
                'created_by'            => 1,
                'updated_by'            => 1,
            ]);
            if ($leave) {
                $response = [
                    'data' => $this->getLeaveById($leave->leave_id, $lang),
                    'code'  => config('constants.codes.success'),
                    'message' => $lang == 'en' ? 'You have successfully submitted your leave request, please wait the approval from your supervisor.' : 'អ្នកបានស្នើច្បាប់ឈប់រួចរាល់ សូមរង់ចាំការឯកភាពពីប្រធានរបស់អ្នក។'
                ];
                return response($response, 201);
            } else {
                $response_fail = [
                    'code' => config('constants.codes.fail_403'),
                    'message' => $lang == 'en' ? config('constants.messages_en.create_fail') : config('constants.messages.create_fail')
                ];
                return response($response_fail, 500);
            }
        }
    }

    public function updateLeaveRequest(Request $request)
    {
        $request->validate([
            'leave_id'  => 'required',
            'leave_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'lang' => 'required'
        ]);
        $lang = $request->lang;
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   =  date('Y-m-d', strtotime($request->end_date));

        if ($this->checkExistingLeave($start_date, $end_date, '', $request->leave_id)) {
            $response = [
                'code' => config('constants.codes.fail_400'),
                'message' => $lang == 'en' ? 'You cannot request the same dates with your previous request!' : 'អ្នកបានស្នើថ្ងៃឈប់ដូចគ្នានឹងការស្នើសុំពីមុនរួចហើយ។ សូមត្រួតពិនិត្យថ្ងៃចាប់ផ្ដើម និងថ្ងៃបញ្ចប់ម្ដងទៀត!'
            ];
            return response($response, 400);
        } else {
            $update_row = array(
                'leave_type_id'         => $request->leave_type_id,
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'description'           => $request->description
            );
            StaffLeave::where('leave_id', $request->leave_id)->update($update_row);
            $response = [
                'data' => $this->getLeaveById($request->leave_id, $lang),
                'code'  => config('constants.codes.success'),
                'message' => $lang == 'en' ? 'You have successfully updated your leave request, please wait the approval from your supervisor.' : 'អ្នកបានកែតម្រូវច្បាប់ឈប់រួចរាល់ សូមរង់ចាំការឯកភាពពីប្រធានរបស់អ្នក។'
            ];
            return response($response, 200);
        }
    }

    public function destroyLeaveRequest(Request $request)
    {
        $request->validate([
            'leave_id'  => 'required',
            'lang' => 'required'
        ]);
        $lang = $request->lang;
        StaffLeave::where('leave_id', $request->leave_id)->delete();
        $response = [
            'code'  => config('constants.codes.success'),
            'message' => $lang == 'en' ? 'You have successfully canceled your leave request.' : 'អ្នកបានលុបចោលការស្នើសុំច្បាប់ឈប់ដោយជោគជ័យ។'
        ];
        return response($response, 200);
    }
}
