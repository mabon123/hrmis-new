<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Carbon\Carbon;
use App\Models\AdminOffice;
use App\Models\Country;
use App\Models\LeaveType;
use App\Models\Location;
use App\Models\Office;
use App\Models\Position;
use App\Models\Province;
use App\Models\Staff;
use App\Models\StaffLeave;
use App\Models\StaffMovement;
use App\Models\StaffStatus;
use App\Models\User;
use App\Models\WorkHistory;

class WorkHistoryController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'edit']]);
    }


    /**
     * List all staff's work history
     *
     * @param  Object  Staff  $staff
     */
    public function index(Staff $staff)
    {
    	$headerid   = $staff->payroll_id;
    	$payroll_id = $staff->payroll_id;
        $userWorkPlace = auth()->user()->work_place;
        $staffProCode = !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->pro_code : 0;

        $locations = Location::where('pro_code', $staffProCode)
                            ->get()
                            ->pluck('location_commune', 'location_code')
                            ->all();

        $staffStatus = StaffStatus::when(auth()->user()->hasRole('school-admin', 'dept-admin', 'doe-admin'), function($query) {
                                    $query->whereNotIn('status_id', [1, 4, 14]);
                                })
                                ->when(auth()->user()->hasRole('poe-admin', 'central-admin', 'administrator'), function($query) {
                                    $query->whereNotIn('status_id', [1, 14]);
                                })
                                ->pluck('status_kh', 'status_id')
                                ->all();
        
        $provinces = Province::active()->pluck('name_kh', 'pro_code')->all();

        //return $provinces;

        $countries = Country::active()->pluck('country_kh', 'country_id')->all();

        // Work history modal
        $positions = Position::pluck('position_kh', 'position_id')->all();

    	$workHistories = WorkHistory::where('payroll_id', $staff->payroll_id)
                                    //->whereNotIn('his_type_id', [5])
                                    ->orderBy('start_date', 'DESC')
                                    ->get();

        // Leave info
        $leaveTypes = LeaveType::active()->pluck('leave_type_kh', 'leave_type_id')->all();

        $leaveHists = StaffLeave::where('payroll_id', $staff->payroll_id)
                                ->whereNotIn(DB::raw("IFNULL(check_status_id, 0)"), [4, 6])
                                 ->orderBy('start_date', 'DESC')
                                 ->get();

        $lastWorkHist = [];
        $offices = [];
        
    	return view('admin.staffs.workhis', compact(
    		'headerid', 'payroll_id', 'staff', 'workHistories', 'staffStatus', 'provinces',
            'countries', 'positions', 'leaveTypes', 'leaveHists', 'offices', 'lastWorkHist',
            'locations', 'staffProCode'
    	));
    }


    /**
     * Store work history info for staff
     */
    public function store(Staff $staff, Request $request)
    {
        $oldStaffStatusID = $staff->staff_status_id;
        $pro_code = $request->pro_code;

        // Validate if start_date > end_date
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $end_date = $request->end_date ? Carbon::createFromFormat('d-m-Y', $request->end_date) : null;

        // Check if end_date < start_date
        if (!is_null($request->end_date) && $start_date->gt($end_date)) {
            return back()->withInput()->withErrors(__('validation.gte_start_date'));
        }
        
    	$workHistoryData = $request->all();

        $curWorkhistory = WorkHistory::where('payroll_id', $staff->payroll_id)
                                    ->where('cur_pos', 1)
                                    ->first();
        
    	// Get location info
    	$location = Location::where('location_code', $request->location_code)->first();

        // if no location data, get from last workhistory with location_code
        if (empty($location) && is_null($request->position_id)) {
            $lastPosition = WorkHistory::where('payroll_id', $staff->payroll_id)
                                       ->whereNotNull('location_code')
                                       ->orderBy('start_date', 'desc')
                                       ->first();
            $location = !empty($lastPosition) ? $lastPosition->location : '';
        }
        
        $position = $request->position_id ? Position::findOrFail($request->position_id) : [];
        $province = $request->pro_code ? Province::findOrFail($request->pro_code) : [];
        $country = $request->country_id ? Country::findOrFail($request->country_id) : [];
        $staffStatus = $request->staff_status_id ? StaffStatus::findOrFail($request->staff_status_id) : [];

        // Transfer within ministry (outside province)
        if ($request->staff_status_id == 4) {
            $description = $staffStatus->status_kh .' '. (!empty($province) ? $province->name_kh : '');
        }
        // Continue study
        elseif ($request->staff_status_id == 10) {
            $description = $staffStatus->status_kh .' ទៅប្រទេស'. (!empty($country) ? $country->country_kh : '');
        }
        // Active
        elseif ($request->staff_status_id == 1) {
            $description = !empty($position) ? $position->position_kh : '';
        }
        else {
            $description = $staffStatus->status_kh;
        }

        // Add prokah number
        if (!empty($description)) {
            $description = $description . ' តាម' . $request->prokah_num;
        }

    	$workHistoryData['pro_code']               = !empty($location) ? $location->pro_code : $request->pro_code;
    	$workHistoryData['location_code'] 	       = !empty($location) ? $location->location_code : null;
        $workHistoryData['sys_admin_office_id']    = $request->sys_admin_office_id > 0 ? $request->sys_admin_office_id : 
                                                     ($request->staff_status_id != 1 ? 
                                                        ($curWorkhistory ? $curWorkhistory->sys_admin_office_id : null) : null);
        $workHistoryData['his_type_id']            = $request->staff_status_id ? $request->staff_status_id : 1; // Position change
        $workHistoryData['country_id']             = $request->country_id ? $request->sys_admin_office_id : null;
    	$workHistoryData['position_id']            = $request->position_id ? $request->position_id : 
                                                     ($curWorkhistory ? $curWorkhistory->position_id : null);
    	$workHistoryData['start_date']             = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
    	$workHistoryData['end_date']               = $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null;
        $workHistoryData['cur_pos']                = 1; // always 1 when create new work_history
        $workHistoryData['description']            = $description;
    	$workHistoryData['created_by']             = Auth::user()->id;
    	$workHistoryData['updated_by']             = Auth::user()->id;
        $workHistoryData['status_id'] = $request->staff_status_id;
        
        $lastWorkHist = $staff->workHistories()->orderBy('start_date', 'desc')->first();

        // If same start_date for new record, then can not add
        if ($workHistoryData['start_date'] == $lastWorkHist->start_date) {

            return redirect()->route('work-histories.index', [app()->getLocale(), $staff->payroll_id])
                         ->withErrors(__('validation.duplicate'));
        }
        elseif ($workHistoryData['start_date'] <= $lastWorkHist->start_date) {
            return redirect()->route('work-histories.index', [app()->getLocale(), $staff->payroll_id])
                         ->withErrors(__('validation.lt_date'));
        }

        // Staff Transfer Process
        if ($request->staff_status_id == 4) {
            if ($request->new_location_code) {
                $newLocation = Location::where('location_code', $request->new_location_code)
                                        ->select('location_code', 'pro_code', 'dis_code')
                                        ->first();
            }
            else {
                $newLocation = Location::when($pro_code == 99, function($query) use($pro_code) {
                                            $query->where('pro_code', $pro_code);
                                            $query->where('location_type_id', 1);
                                        })
                                        ->when($pro_code != 99, function($query) use($pro_code) {
                                            $query->where('pro_code', $pro_code);
                                            $query->where('location_type_id', 12);
                                        })
                                        ->select('location_code', 'pro_code', 'dis_code')
                                        ->first();
            }

            // Change location_code for staff transfer
            //$workHistoryData['location_code'] = $newLocation->location_code; // 28-01-2022
            
            StaffMovement::create([
                'payroll_id' => $staff->payroll_id,
                'old_pro_code' => $location->pro_code,
                'old_dis_code' => !is_null($location->dis_code) ? $location->dis_code : 0,
                'old_location_code' => $location->location_code,
                'old_status_id' => $oldStaffStatusID,
                'moveout_date' => Carbon::now(),
                'new_pro_code' => $newLocation->pro_code,
                'new_dis_code' => !is_null($newLocation->dis_code) ? $newLocation->dis_code : 0,
                'new_location_code' => $newLocation->location_code,
                'new_status_id' => $request->staff_status_id,
                'movein_date' => null,
                'transfer_status' => 0,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            // If staff transfer, change user role of that staff to mobile user
            $user = User::where('payroll_id', $staff->payroll_id)->first();
            
            if ($user) {
                $user->fill(['level_id' => 5, 'reg_type' => 2])->save();
                $user->roles()->detach();
                $user->roles()->attach(8, ['created_by' => auth()->user()->id]);
            }
        }

        // Update existing current position info
        $oldCurPos = $staff->workHistories()->where('cur_pos', 1)->first();

        if (!empty($oldCurPos)) {
            $oldCurPos->fill([
                            'cur_pos' => 0, 
                            'end_date' => $workHistoryData['start_date'],
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ])
                        ->save();
        }
        
        // Create new workhistory info
    	$staff->workHistories()->create($workHistoryData);

        // Change staff status to active
        $staff->fill(['staff_status_id' => $workHistoryData['his_type_id']])->save();

    	return redirect()->route('work-histories.index', [app()->getLocale(), $staff->payroll_id])
    					 ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit existing work history info
     *
     * @param  number  $work_history
     */
    public function edit($workhistoryID)
    {
    	$workhistory = WorkHistory::where('hrmis_work_histories.workhis_id', $workhistoryID)->first();
        
    	$workhistory->start_date = $workhistory->start_date > 0 ? date('d-m-Y', strtotime($workhistory->start_date)) : '';
    	$workhistory->end_date = $workhistory->end_date > 0 ? date('d-m-Y', strtotime($workhistory->end_date)) : '';
        $workhistory->location_kh = !empty($workhistory->location) ? $workhistory->location->location_kh : '';

    	// Get office info
    	$office = Office::where('office_id', $workhistory->sys_admin_office_id)->first();

    	$workhistory->sys_admin_office = !empty($office) ? $office->office_kh : '';

    	// Get admin office
    	$location = Location::where('location_code', $workhistory->location_code)->first();

    	$workhistory->sys_admin_offices = !empty($location) ? $location->offices : [];

    	return $workhistory;
    }


    /**
     * Update existing work history info
     *
     * @param  WorkHistory  $work_history
     */
    public function update(WorkHistory $work_history, Request $request)
    {
    	$workHistoryData = $request->all();
        $location_code = $request->location_code ? $request->location_code : $work_history->location_code;

    	// Get location info
        $location = Location::where('location_code', $location_code)->first();
        $position = $request->position_id ? Position::findOrFail($request->position_id) : [];
        $province = $request->pro_code ? Province::findOrFail($request->pro_code) : [];
        $country = $request->country_id ? Country::findOrFail($request->country_id) : [];
        $staffStatus = StaffStatus::where('status_id', $work_history->his_type_id)->first();

        // Transfer within ministry (outside province)
        if ($work_history->his_type_id == 4) {
            $description = $staffStatus->status_kh .' '. (!empty($province) ? $province->name_kh : '');
        }
        // Continue study
        elseif ($work_history->his_type_id == 10) {
            $description = $staffStatus->status_kh .' ទៅប្រទេស'. (!empty($country) ? $country->country_kh : '');
        }
        // Active
        elseif ($request->staff_status_id == 1) {
            $description = !empty($position) ? $position->position_kh : '';
        }
        else {
            $description = $staffStatus->status_kh;
        }
        
        // Add prokah number
        if (!empty($description)) {
            $description = $description . ($request->prokah_num ? ' តាម' . $request->prokah_num : '');
        }
        
        if ($work_history->his_type_id == 1) {
            $workHistoryData['pro_code'] = !empty($location) ? $location->pro_code : $work_history->pro_code;
            $workHistoryData['location_code'] = $location_code;
            $workHistoryData['description'] = $description;
            $workHistoryData['start_date'] = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
            $workHistoryData['end_date'] = $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null;
        }
        else {
            $workHistoryData['pro_code'] = !is_null($request->pro_code) ? $request->pro_code : $work_history->pro_code;
            $workHistoryData['description'] = $description;
            $workHistoryData['start_date'] = $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null;
            $workHistoryData['end_date'] = $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null;
        }

        //$workHistoryData['cur_pos'] = $work_history->cur_pos;
        $workHistoryData['updated_by'] = Auth::user()->id;
        $workHistoryData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        
    	$work_history->fill($workHistoryData)->save();

    	return redirect()->route('work-histories.index', [app()->getLocale(), $work_history->payroll_id])
    					 ->withSuccess(__('validation.update_success'));
    }


    /**
     * Remove existing work history
     *
     * @param  WorkHistory $work_history
     */
    public function destroy(WorkHistory $work_history)
    {
    	$work_history->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
