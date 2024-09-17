<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Staff;
use App\Models\WorkHistory;
use App\Models\StaffFamily;
use App\Models\Profile\ProfileCheck;

class StaffApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getLocationCodes()
    {
        $curWorkPlace = WorkHistory::where('payroll_id', Auth::user()->payroll_id)
            ->where('cur_pos', 1)
            ->select('pro_code', DB::raw("LEFT(location_code, 4) as dis_code"), 'location_code')
            ->first();
        return $curWorkPlace;
    }

    /**
     * List of all staffs that need approval from School Director, DoE, PoE
     *
     * @return $staffs
     */
    public function staffNeedApproval()
    {
        $staffs = [];
        $payroll_id = Auth::user()->payroll_id;
        $pro_code = '0';
        $dis_code = '0';
        $location_code = '0';
        $curWorkPlace = $this->getLocationCodes();
        if ($curWorkPlace) {
            $pro_code = $curWorkPlace->pro_code;
            $dis_code = $curWorkPlace->dis_code;
            $location_code = $curWorkPlace->location_code;
        }

        if (Auth::user()->hasRole('school-admin')) {
            $staffs = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('school_check_status', 4)
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'school_check_status as check_status'
                )
                //->distinct() //Not working with pagination. Use groupBy instead.
                ->groupBy('hrmis_profile_checks.payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'school_check_status')
                ->orderBy('hrmis_profile_checks.payroll_id')
                ->paginate(10);
        } elseif (Auth::user()->hasRole('doe-admin')) {
            $staffs = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('doe_check_status', 4)
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'doe_check_status as check_status'
                )
                ->groupBy('hrmis_profile_checks.payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'doe_check_status')
                ->orderBy('hrmis_profile_checks.payroll_id')
                ->paginate(10);
        } elseif (Auth::user()->hasRole('poe-admin')) {
            //Staff inside POE
            $q_1 = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('poe_check_status', 4)
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'poe_check_status as check_status'
                )
                ->distinct();

            //Union with Staff in school or DOE who requested to change DOB
            $staffs = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('hrmis_profile_checks.field_id', '011')
                ->where('pro_code', $pro_code)
                ->where('poe_check_status', 4)
                ->where(function ($query) {
                    $query->where('school_check_status', 5)
                        ->orWhere('doe_check_status', 5);
                })
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'poe_check_status as check_status'
                )
                ->distinct()
                ->union($q_1)
                ->paginate(10);
        } elseif (Auth::user()->hasRole('dept-admin')) {
            $staffs = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('department_check_status', 4)
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'department_check_status as check_status'
                )
                ->groupBy('hrmis_profile_checks.payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'department_check_status')
                ->orderBy('hrmis_profile_checks.payroll_id')
                ->paginate(10);
        } elseif (Auth::user()->hasRole('administrator')) {
            $staffs = ProfileCheck::join('hrmis_staffs as t2', 'hrmis_profile_checks.payroll_id', '=', 't2.payroll_id')
                ->where('field_id', '011') //Staff's DOB
                ->where('admin_check_status', 4) //Pending for admin's approval
                ->where(function ($query) {
                    $query->where('poe_check_status', 5)
                        ->orWhere('department_check_status', 5);
                })
                ->select(
                    'hrmis_profile_checks.payroll_id',
                    'surname_kh',
                    'name_kh',
                    'surname_en',
                    'name_en',
                    'sex',
                    DB::raw("DATE_FORMAT(dob, '%d-%m-%Y') as dob"),
                    'admin_check_status as check_status'
                )
                ->groupBy('hrmis_profile_checks.payroll_id', 'surname_kh', 'name_kh', 'surname_en', 'name_en', 'sex', 'admin_check_status')
                ->orderBy('hrmis_profile_checks.payroll_id')
                ->paginate(10);
        } else {
            $staffs = [];
        }
        return view('admin.staffs.approval.pending', compact('staffs'));
    }

    public function profileDetail(Staff $staff)
    {
        $headerid = $staff->payroll_id;
        $login_id = Auth::user()->payroll_id;

        $pro_code = '0';
        $dis_code = '0';
        $location_code = '0';
        $curWorkPlace = $this->getLocationCodes();
        if ($curWorkPlace) {
            $pro_code = $curWorkPlace->pro_code;
            $dis_code = $curWorkPlace->dis_code;
            $location_code = $curWorkPlace->location_code;
        }

        $data = [];
        if (Auth::user()->hasRole('school-admin')) {
            $data = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->where('payroll_id', $headerid) //staff's id
                ->where('school_check_status', 4)
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'school_check_status as check_status'
                )
                ->orderBy('hrmis_profile_checks.field_id')
                ->get();
        } elseif (Auth::user()->hasRole('doe-admin')) {
            $data = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->where('payroll_id', $headerid) //staff's id
                ->where('doe_check_status', 4)
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'doe_check_status as check_status',
                    DB::raw("DATE_FORMAT(school_check_date, '%d-%m-%Y %H:%i') As school_check_date")
                )
                ->orderBy('hrmis_profile_checks.field_id')
                ->get();
        } elseif (Auth::user()->hasRole('poe-admin')) {
            //Staff inside POE
            $q_1 = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('hrmis_profile_checks.payroll_id', $headerid) //staff's id
                ->where('location_code', $location_code)
                ->where('poe_check_status', 4)
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'hrmis_profile_checks.payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'poe_check_status as check_status',
                    'school_check_status',
                    'doe_check_status',
                    DB::raw("DATE_FORMAT(school_check_date, '%d-%m-%Y %H:%i') As school_check_date"),
                    DB::raw("DATE_FORMAT(doe_check_date, '%d-%m-%Y %H:%i') As doe_check_date")
                );

            //Union with Staff in school or DOE who requested to change DOB
            $data = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('hrmis_profile_checks.payroll_id', $headerid) //staff's id
                ->where('hrmis_profile_checks.field_id', '011')
                ->where('pro_code', $pro_code)
                ->where('poe_check_status', 4)
                ->where(function ($query) {
                    $query->where('school_check_status', 5)
                        ->orWhere('doe_check_status', 5);
                })
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'hrmis_profile_checks.payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'poe_check_status as check_status',
                    'school_check_status',
                    'doe_check_status',
                    DB::raw("DATE_FORMAT(school_check_date, '%d-%m-%Y %H:%i') As school_check_date"),
                    DB::raw("DATE_FORMAT(doe_check_date, '%d-%m-%Y %H:%i') As doe_check_date")
                )
                ->union($q_1)
                ->get();

            //After POE clicked then update automatically on the alert fields. Work Info, Salary Info, & Children Info
            //ProfileCheck::where('payroll_id', $headerid)->whereIn('field_id', ['018', '019', '034'])->update(['poe_approver' => $login_id, 'poe_check_status' => 5, 'poe_check_date' => now()]);
        } elseif (Auth::user()->hasRole('dept-admin')) {
            $data = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->join('hrmis_work_histories', 'hrmis_profile_checks.payroll_id', '=', 'hrmis_work_histories.payroll_id')
                ->where('cur_pos', 1)
                ->where('location_code', $location_code)
                ->where('hrmis_profile_checks.payroll_id', $headerid) //staff's id
                ->where('department_check_status', 4)
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'hrmis_profile_checks.payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'department_check_status as check_status'
                )
                ->orderBy('hrmis_profile_checks.field_id')
                ->get();
        } elseif (Auth::user()->hasRole('administrator')) {
            $data = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                ->where('hrmis_profile_checks.field_id', '011')
                ->where('payroll_id', $headerid) //staff's id
                ->where('admin_check_status', 4) //Pending for admin's approval
                ->where(function ($query) {
                    $query->where('poe_check_status', 5)
                        ->orWhere('department_check_status', 5);
                })
                ->select(
                    'hrmis_profile_checks.id',
                    'hrmis_profile_checks.field_id',
                    'payroll_id',
                    't2.field_title_kh',
                    't2.table_name',
                    't2.field_title_en',
                    'hrmis_profile_checks.correct_value',
                    'admin_check_status as check_status'
                )
                ->orderBy('hrmis_profile_checks.field_id')
                ->get();
        } else {
            $data = [];
        }

        return view('admin.staffs.approval.details', compact('data', 'headerid'));
    }
    public function fieldCheckApproval(Staff $staff, Request $request)
    {
        $payroll_id = $staff->payroll_id;
        $checkIds = $request->check_id;
        if ($checkIds) {
            try {
                $family = StaffFamily::whereIn('relation_type_id', [1, 2])
                    ->where('payroll_id', $payroll_id)->first();

                $staffChecks = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                    ->whereIn('id', $checkIds)->where('table_name', 'hrmis_staffs')
                    ->select('t2.field_id', 'field_name', 'correct_value')
                    ->get();

                $spouseChecks = ProfileCheck::join('sys_field_checks as t2', 'hrmis_profile_checks.field_id', '=', 't2.field_id')
                    ->whereIn('id', $checkIds)->where('table_name', 'hrmis_families')
                    ->select('t2.field_id', 'field_name', 'correct_value')
                    ->get();

                $staffData = array();
                $familyData = array();
                // Staff's info
                foreach ($staffChecks as $index => $value) {
                    if (Auth::user()->hasRole('administrator')) {
                        $staffData[$value->field_name] = $value->correct_value;
                    } else {
                        if ($value->field_id != '011') { //Skip DOB update for other roles beside system administrator
                            if ($value->field_id == '013') {
                                $staffData['disability_teacher'] = 1;
                                $staffData[$value->field_name] = $value->correct_value;
                            } else {
                                $staffData[$value->field_name] = $value->correct_value;
                            }
                        }
                    }
                }
                //Spouse's info
                foreach ($spouseChecks as $index => $value) {
                    $familyData[$value->field_name] = $value->correct_value;
                }
                if (count($staffData)) {
                    $staffData['updated_by'] = Auth::user()->id;
                    $staff->fill($staffData)->save();
                }
                if (count($familyData)) {
                    $familyData['allowance'] = (isset($familyData['occupation']) && $familyData['occupation'] == "មន្រ្តីរាជការ") ? 0 : 1;
                    if ($family) { //Check if spouse's info exist then update
                        $familyData['updated_by'] = Auth::user()->id;
                        $family->fill($familyData)->save();
                    } else {
                        $familyData['payroll_id']       = $payroll_id;
                        $familyData['relation_type_id'] = $staff->sex == 1 ? 2 : 1;
                        $familyData['fullname_kh']      = $familyData['fullname_kh'] ? $familyData['fullname_kh'] : '';
                        $familyData['gender']             = $familyData['relation_type_id'];
                        $familyData['created_by']         = Auth::user()->id;
                        $familyData['updated_by']         = Auth::user()->id;

                        StaffFamily::create($familyData);
                    }
                }

                $update_rows = array();
                if (Auth::user()->hasRole('school-admin')) {
                    $update_rows['school_approver'] = Auth::user()->payroll_id;
                    $update_rows['school_check_status'] = 5;
                    $update_rows['school_check_date'] = now();
                } elseif (Auth::user()->hasRole('doe-admin')) {
                    $update_rows['doe_approver'] = Auth::user()->payroll_id;
                    $update_rows['doe_check_status'] = 5;
                    $update_rows['doe_check_date'] = now();
                } elseif (Auth::user()->hasRole('poe-admin')) {
                    $update_rows['poe_approver'] = Auth::user()->payroll_id;
                    $update_rows['poe_check_status'] = 5;
                    $update_rows['poe_check_date'] = now();
                } elseif (Auth::user()->hasRole('dept-admin')) {
                    $update_rows['department_approver'] = Auth::user()->payroll_id;
                    $update_rows['department_check_status'] = 5;
                    $update_rows['department_check_date'] = now();
                } else {
                    $update_rows['admin_approver'] = Auth::user()->payroll_id;
                    $update_rows['admin_check_status'] = 5;
                    $update_rows['admin_check_date'] = now();
                }
                ProfileCheck::whereIn('id', $checkIds)->update($update_rows);
                return redirect()->route('profile.need.approval', app()->getLocale())
                    ->withSuccess(__('common.profilecheck_success'));
            } catch (\Throwable $th) {
                return back()->withInput()->withErrors($th->getMessage());
            }
        }
        return back()->withInput()->withErrors(__('common.profilecheck_fail'));
    }

    public function destroy($id)
    {
        $profile = ProfileCheck::find($id);
        $profile->delete();
        return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
