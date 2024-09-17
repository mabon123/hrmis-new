<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Province;
use App\Models\District;
use App\Models\Location;
use App\Models\Position;
use App\Models\Staff;
use App\Models\StaffMovement;
use App\Models\WorkHistory;

class StaffTransferController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:view-reports', ['only' => ['index']]);
    }
    
    // Show staff transfer
    public function showStaffTransferInInfo()
    {
        $userWorkPlace = auth()->user()->work_place;
        $districts = [];
        $locations = [];

        $oldLocations = Location::join('hrmis_staff_movements', 'sys_locations.location_code', '=', 'hrmis_staff_movements.old_location_code')
                                ->when(!auth()->user()->hasRole('administrator'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_pro_code', $userWorkPlace->pro_code);
                                })
                                ->where('hrmis_staff_movements.transfer_status', 0)
                                ->pluck('sys_locations.location_kh', 'sys_locations.location_code')
                                ->all();

        $newLocations = Location::join('hrmis_staff_movements', 'sys_locations.location_code', '=', 'hrmis_staff_movements.new_location_code')
                                ->when(!auth()->user()->hasRole('administrator'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_pro_code', $userWorkPlace->pro_code);
                                })
                                ->where('hrmis_staff_movements.transfer_status', 0)
                                ->pluck('sys_locations.location_kh', 'sys_locations.location_code')
                                ->all();

        // Modal data dropdown
        $provinces = user_provinces();
        $districts = user_districts();
        
        if (auth()->user()->hasRole('poe-admin', 'central-admin', 'administrator')) {
            //$districts = user_districts();
            //$locations = user_locations();
        }

        if (auth()->user()->hasRole('administrator')) {
            //$provinces = ['' => __('common.choose').' ...'] + $provinces;
            //$districts = District::active()->pluck('name_kh', 'dis_code')->all();
        }
        
        $selectQuery = ['hrmis_staffs.payroll_id', 'surname_kh', 'name_kh', 'sex', 'dob', 'surname_en', 'name_en', 'staff_status_id',
                        'hrmis_staff_movements.old_location_code', 'hrmis_staff_movements.new_location_code', 
                        'hrmis_staff_movements.old_pro_code', 'hrmis_staff_movements.new_pro_code'];

        $staffs = StaffMovement::join('hrmis_staffs', 'hrmis_staff_movements.payroll_id', '=', 'hrmis_staffs.payroll_id')
                                ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_location_code', $userWorkPlace->location_code);
                                })
                                ->when(auth()->user()->hasRole('doe-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_dis_code', $userWorkPlace->dis_code);
                                })
                                ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_pro_code', $userWorkPlace->pro_code);
                                })
                                ->where('hrmis_staff_movements.transfer_status', 0)
                                ->when(request()->payroll, function($query) {
                                    $query->where('hrmis_staff_movements.payroll_id', 'like', '%'.request()->payroll.'%');
                                })
                                ->when(request()->fullname, function($query) {
                                    $query->where('hrmis_staffs.surname_kh', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.name_kh', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.surname_en', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.name_en', 'like', '%'.request()->fullname.'%');
                                })
                                ->when(request()->old_location, function($query) {
                                    $query->where('hrmis_staff_movements.old_location_code', request()->old_location);
                                })
                                ->when(request()->new_location, function($query) {
                                    $query->where('hrmis_staff_movements.new_location_code', request()->new_location);
                                })
                                ->select($selectQuery)
                                ->paginate(20);

        $femaleStaffs = StaffMovement::join('hrmis_staffs', 'hrmis_staff_movements.payroll_id', '=', 'hrmis_staffs.payroll_id')
                                ->when(auth()->user()->hasRole('school-admin', 'dept-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_location_code', $userWorkPlace->location_code);
                                })
                                ->when(auth()->user()->hasRole('doe-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_dis_code', $userWorkPlace->dis_code);
                                })
                                ->when(auth()->user()->hasRole('poe-admin', 'central-admin'), function($query) use($userWorkPlace) {
                                    $query->where('hrmis_staff_movements.new_pro_code', $userWorkPlace->pro_code);
                                })
                                ->when(request()->payroll, function($query) {
                                    $query->where('hrmis_staff_movements.payroll_id', 'like', '%'.request()->payroll.'%');
                                })
                                ->when(request()->fullname, function($query) {
                                    $query->where('hrmis_staffs.surname_kh', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.name_kh', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.surname_en', 'like', '%'.request()->fullname.'%');
                                    $query->orWhere('hrmis_staffs.name_en', 'like', '%'.request()->fullname.'%');
                                })
                                ->when(request()->old_location, function($query) {
                                    $query->where('hrmis_staff_movements.old_location_code', request()->old_location);
                                })
                                ->when(request()->new_location, function($query) {
                                    $query->where('hrmis_staff_movements.new_location_code', request()->new_location);
                                })
                                ->where('hrmis_staff_movements.transfer_status', 0)
                                ->where('hrmis_staffs.sex', '2')
                                ->distinct()
                                ->count('hrmis_staffs.payroll_id');

        return view('admin.reports.movedin_staff', compact(
                'staffs', 'femaleStaffs', 
                'provinces', 'districts', 'locations', 'oldLocations', 'newLocations'
            ));
    }

    // Accept staff transfer
    public function acceptTransfer(Request $request)
    {
        $request->validate([
            'payroll_ids' => 'required'
        ]);

        foreach ($request->payroll_ids as $payroll_id) {
            $staffMovement = StaffMovement::where('payroll_id', $payroll_id)->first();

            // Update staff_status_id in hrmis_staffs table
            $staff = Staff::where('payroll_id', $payroll_id)->first();
            $staff->fill(['staff_status_id' => 1])->save();

            // Create new workhistory
            $staffWorkhistory = WorkHistory::where('payroll_id', $payroll_id)
                                            ->where('cur_pos', 1)
                                            ->first();

            $staffPositionID = 0;
            $additionalPositionID = 0;
            $prokahNum = 0;
            $prokah = 0;

            if (!empty($staffWorkhistory)) {
                $staffPositionID = $staffWorkhistory->position_id;
                $additionalPositionID = $staffWorkhistory->additional_position_id;
                $prokahNum = $staffWorkhistory->prokah_num;
                $prokah = $staffWorkhistory->prokah;
            }

            $position = Position::where('position_id', $staffPositionID)->first();
            $description = (!empty($position) ? $position->position_kh : '').' តាមប្រកាសលេខ '.$prokahNum;

            WorkHistory::create([
                'pro_code' => $staffMovement->new_pro_code,
                'location_code' => $staffMovement->new_location_code,
                'sys_admin_office_id' => null,
                'payroll_id' => $payroll_id,
                'his_type_id' => 1,
                'country_id' => null,
                'position_id' => $staffPositionID,
                'additional_position_id' => $additionalPositionID,
                'prokah' => $prokah,
                'prokah_num' => $prokahNum,
                'cur_pos' => 1,
                'main_duty' => null,
                'description' => $description,
                'start_date' => Carbon::now(),
                'end_date' => null,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            // Update staff last workhistory
            $staffWorkhistory->fill([
                'cur_pos' => 0,
                'end_date' => Carbon::now(),
            ])->save();

            // Update movein_date of staff_movement
            $staffMovement->fill([
                'movein_date' => Carbon::now(),
                'transfer_status' => 1,
            ])->save();
        }

        return redirect()->route('reports.showStaffTransferInInfo', app()->getLocale())
            ->withSuccess(__('validation.transfer_success'));
    }

    // For POE - Admin, choose new workplace for transferred staff
    public function chooseNewWorkplace(Staff $staff, Request $request)
    {
        $staffMovement = StaffMovement::where('payroll_id', $staff->payroll_id)
                                    ->where('transfer_status', 0)
                                    ->first();
        $location = Location::where('location_code', $request->location_code)
                            ->select('pro_code', 'dis_code')
                            ->first();
        
        $staffMovement->fill([
            'new_pro_code' => (!empty($location) && !is_null($location->pro_code)) ? $location->pro_code : 0,
            'new_dis_code' => (!empty($location) && !is_null($location->dis_code)) ? $location->dis_code : 0,
            'new_location_code' => $request->location_code,
        ])->save();

        // Update workhistory
        $workhistory = WorkHistory::where('payroll_id', $staff->payroll_id)
                                ->where('cur_pos', 1)
                                ->first();

        $workhistory->fill(['location_code' => $request->location_code])->save();

        return redirect()->route('reports.showStaffTransferInInfo', app()->getLocale())
            ->withSuccess(__('validation.change_location_success'));
    }
}
