<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\ContractStaffPosition;
//use App\Models\ContractTeacher;
//use App\Models\ContractTeacherHistory;
use App\Models\Location;
use App\Models\Staff;
use App\Models\WorkHistory;

class ContTeacherWorkHistoryController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:edit-cont-staffs');
    }


    /**
     * All conteact teacher work history
     *
     * @param  Object  Staff  $contract_teacher
     */
    public function index(Staff $contract_teacher)
    {
    	$workHistories = WorkHistory::where('payroll_id', $contract_teacher->payroll_id)
    								->orderBy('start_date', 'DESC')
    								->get();

    	return view('admin.contract_teachers.workhistory_listing', compact(
    			'contract_teacher', 'workHistories'
    		));
    }


    /**
     * Store contract teacher work history
     *
     * @param  number  $payroll_id
     */
    public function store($payroll_id, Request $request)
    {
        $contractStaff = Staff::where('payroll_id', $payroll_id)->first();
        
        // Update old curpos == 1 to 0
        $currentWorkHist = WorkHistory::where('payroll_id', $payroll_id)->where('cur_pos', 1)->first();

        if (!empty($currentWorkHist)) {
            $currentWorkHist->fill([
                'cur_pos' => 0,
                //'end_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ])->save();
        }

        // Get location info
        $location = Location::where('location_code', $request->location_code)
                            ->select('pro_code', 'location_code', 'location_kh', 'dis_code', 'com_code', 'vil_code')
                            ->first();

    	WorkHistory::create([
            'pro_code' => $location->pro_code,
            'location_code' => $location->location_code,
            'location_kh' => $location->location_kh,
            'location_pro_code' => $request->location_pro_code ? $request->location_pro_code : null,
            'location_dis_code' => $request->location_dis_code ? $request->location_dis_code : null,
            'location_com_code' => $request->location_com_code ? $request->location_com_code : null,
            'location_vil_code' => $request->location_vil_code ? $request->location_vil_code : null,
            'sys_admin_office_id' => null,
            'payroll_id' => $payroll_id,
            'his_type_id' => 1,
            'country_id' => null,
            'position_id' => null,
            'additional_position_id' => null,
            'status_id' => 1,
            'prokah' => 0,
            'prokah_num' => null,
            'cur_pos' => 1,
            'main_duty' => $request->duty,
            'annual_eval' => $request->annual_eval,
            'has_refilled_training' => $request->has_refilled_training ? 1 : 0,
            'year_refilled_num' => $request->year_refilled_num ? $request->year_refilled_num : null,
            'contract_type_id' => $request->contract_type_id,
            'cont_pos_id' => $request->cont_pos_id,
            'description' => $request->description,
            'start_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
            'end_date' => $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null,
            'official_rank_id' => null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'dis_code'=>$location->dis_code
        ]);

    	return redirect()->route('contract-teachers.work-histories.index', [app()->getLocale(), $payroll_id])
    					 ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit contract teacher work history
     *
     * @param  $payroll_id
     * @param  WorkHistory  $work_history
     */
    public function edit($payroll_id, WorkHistory $work_history)
    {
        // Get contract staff position belong to contract type
        $contPositions = ContractStaffPosition::where('contract_type_id', $work_history->contract_type_id)->get();


    	$work_history->location_kh = !empty($work_history->location) ? $work_history->location->location_kh : $work_history->location_kh;

    	$work_history->start_date = date('d-m-Y', strtotime($work_history->start_date));
    	
    	$work_history->end_date = $work_history->end_date > 0 ? 
    								date('d-m-Y', strtotime($work_history->end_date)) : null;

        $work_history->cont_positions = $contPositions;

    	return $work_history;
    }


    /**
     * Update contract teacher work history
     *
     * @param  number  $payroll_id
     * @param  WorkHistory  $work_history
     */
    public function update($payroll_id, WorkHistory $work_history, Request $request)
    {
    	// Get location info
        $location = Location::where('location_code', $request->location_code)
    						->select('location_code', 'location_kh', 'pro_code', 'dis_code', 'com_code', 'vil_code')
    						->first();
        
    	$work_history->fill([
            'pro_code' => $location->pro_code,
            'location_code' => $location->location_code,
            'location_kh' => $location->location_kh,
            'location_pro_code' => null,
            'location_dis_code' => null,
            'location_com_code' => null,
            'location_vil_code' => null,
            'sys_admin_office_id' => null,
            'his_type_id' => 1,
            'country_id' => null,
            'position_id' => null,
            'additional_position_id' => null,
            'status_id' => 1,
            'prokah' => 0,
            'prokah_num' => null,
            'cur_pos' => 1,
            'main_duty' => $request->duty,
            'annual_eval' => $request->annual_eval,
            'has_refilled_training' => $request->has_refilled_training ? 1 : 0,
            'year_refilled_num' => $request->year_refilled_num ? $request->year_refilled_num : null,
            'contract_type_id' => $request->contract_type_id,
            'cont_pos_id' => $request->cont_pos_id,
            'description' => $request->description,
            'start_date' => $request->start_date > 0 ? date('Y-m-d', strtotime($request->start_date)) : null,
            'end_date' => $request->end_date > 0 ? date('Y-m-d', strtotime($request->end_date)) : null,
            'official_rank_id' => null,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'dis_code'=>$location->dis_code
        ])->save();

    	return redirect()->route('contract-teachers.edit', [app()->getLocale(), $payroll_id])
    					 ->with('success', 'Work history has been updated successfully.');
    }


    /**
     * Remove contract teacher work history
     *
     * @param  number  $payroll_id
     * @param  WorkHistory  $work_history
     */
    public function destroy($payroll_id, WorkHistory $work_history)
    {
    	$work_history->delete();

    	return $work_history;
    }
}
