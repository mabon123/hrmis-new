<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\MaritalStatus;
use App\Models\Province;
use App\Models\RelationshipType;
use App\Models\Staff;
use App\Models\StaffFamily;

class StaffFamilyController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('permission:create-staffs', ['only' => ['index', 'store']]);
    }


    /**
     * List staff family info belong to a staff
     *
     * @param  Staff  $staff
     */
    public function index(Staff $staff)
    {
    	$headerid   = $staff->payroll_id;
    	$payroll_id = $staff->payroll_id;

    	$maritalStatusInfo = MaritalStatus::all();
    	$relationshipTypes = RelationshipType::all();

    	$provinces = Province::active()->whereNotIn('pro_code', ['99'])->get();

    	$staffFamily = StaffFamily::where('payroll_id', $payroll_id)
    							  ->whereIn('relation_type_id', [1, 2])
    							  ->first();

    	$childrens = StaffFamily::where('payroll_id', $payroll_id)
    							->whereIn('relation_type_id', [3])
    							->get();

    	return view('admin.staffs.familyinfo', compact(
    			'headerid', 'payroll_id', 'staff', 'maritalStatusInfo', 'relationshipTypes',
    			'provinces', 'staffFamily', 'childrens'
    		));
    }


    /**
     * Store family info of student
     *
     * @param  Object Staff $staff
     */
    public function store(Staff $staff, Request $request)
    {
        if ($request->maritalstatus_id == 2) {
            $request->validate([
                'spouse_name' => 'required',
                'spouse_dob' => 'required',
                'spouse_occupation' => 'required',
            ], [
                'spouse_name.required' => 'សូមបំពេញ ' . __('family_info.spouse_name'),
                'spouse_dob.required' => 'សូមបំពេញ ' . __('family_info.spouse_dob'),
                'spouse_occupation.required' => 'សូមបំពេញ ' . __('family_info.spouse_occupation'),
            ]);
        }

    	// STAFF DATA
        $phoneWithoutMinus = str_replace('-', '', $request->phone_number);
        $phoneWithoutSpace = str_replace('_', '', $phoneWithoutMinus);

    	$staffData['maritalstatus_id'] 	= $request->maritalstatus_id;
    	$staffData['house_num'] 		= $request->house_number;
    	$staffData['street_num'] 		= $request->street;
    	$staffData['group_num'] 		= $request->group_number;
    	$staffData['adr_pro_code'] 		= $request->adr_pro_code;
    	$staffData['adr_dis_code'] 		= $request->adr_dis_code;
    	$staffData['adr_com_code'] 		= $request->adr_com_code;
    	$staffData['adr_vil_code'] 		= $request->adr_vil_code;
    	$staffData['phone'] 			= $phoneWithoutSpace;
    	$staffData['email'] 			= $request->email_address;
    	
    	$staff->fill($staffData)->save(); // Update staff info

    	// STAFF FAMILY DATA - If have wife/husband
        if ($request->maritalstatus_id != 1) {
        	$familyData['payroll_id'] 		= $staff->payroll_id;
        	$familyData['relation_type_id'] = $staff->sex == 1 ? 2 : 1; // 2: Wife, 1: Husband
        	$familyData['fullname_kh'] 		= $request->spouse_name;
        	$familyData['dob'] 				= $request->spouse_dob > 0 ? date('Y-m-d', strtotime($request->spouse_dob)) : null;
        	$familyData['gender'] 			= $familyData['relation_type_id'];
        	$familyData['occupation'] 		= $request->spouse_occupation;
        	$familyData['spouse_workplace'] = $request->spouse_workplace;
            $familyData['allowance']        = $request->spouse_amount ? 1 : 0;
        	$familyData['phone_number']     = $request->spouse_phone;
        	$familyData['created_by'] 		= Auth::user()->id;
        	$familyData['updated_by'] 		= Auth::user()->id;

            if ($request->maritalstatus_id == 3 || $request->maritalstatus_id == 4) {
                $familyData['fullname_kh'] = null;
                $familyData['dob'] = null;
                $familyData['occupation'] = null;
                $familyData['spouse_workplace'] = null;
                $familyData['allowance'] = 0;
                $familyData['phone_number'] = null;
            }

            $staffFamily = StaffFamily::where('payroll_id', $staff->payroll_id)
                                  ->whereIn('relation_type_id', [1, 2])
                                  ->first();
            
            if (empty($staffFamily)) {
                StaffFamily::create($familyData); // Create family info
            }
            else {
                $staffFamily->fill($familyData)->save(); // Create family info
            }
        }

        // If update from married to single or ...
        else {
        	$staffFamily = StaffFamily::where('payroll_id', $staff->payroll_id)->get();
            
        	if (count($staffFamily)) {
                StaffFamily::where('payroll_id', $staff->payroll_id)->delete();
            }
        }

        return redirect()->route('families.index', [app()->getLocale(), $staff->payroll_id])
                         ->withSuccess(__('validation.update_success'));
    }


    /**
     * Store children information
     */
}
