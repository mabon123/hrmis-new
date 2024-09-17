<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use App\Models\StaffSalary;

class SalaryHistoryController extends Controller
{
    /**
     * Store staff salary history
     */
    private $arab_number = [];
    private $unicode_number = [];

    public function __construct() {
        $this->arab_number        = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $this->unicode_number     = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];
    }

    public function store(Request $request)
    {
    	$salaryData = $request->all();

        $signedDate     = $request->salary_type_signdate;
        $shiftDate      = $request->salary_type_shift_date;
        $specialDate    = $request->salary_special_shift_date;
        $salaryData['salary_thanorn']                = (double)($request->salary_level_id . "." . str_replace($this->unicode_number, $this->arab_number, $request->salary_degree));
    	$salaryData['salary_type_shift_date']    = $shiftDate > 0 ? date('Y-m-d', strtotime($shiftDate)) : null;
        $salaryData['salary_special_shift_date'] = $specialDate > 0 ? date('Y-m-d', strtotime($specialDate)) : null;
        $salaryData['salary_type_signdate']      = $signedDate > 0 ? date('Y-m-d', strtotime($signedDate)) : null;

        $salaryData['created_by'] = Auth::user()->id;
        $salaryData['updated_by'] = Auth::user()->id;
        $salaryData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        StaffSalary::create($salaryData);

        StaffSalary::where('payroll_id', $request->payroll_id)->update(['highest_salary' => 0]); 
        $dd_salaryData = StaffSalary::where('payroll_id', $request->payroll_id)->orderBy('salary_thanorn', 'ASC')->first();
        $dd_salaryData->update(['highest_salary' => 1]); 

        return redirect()->route('staffs.edit', [app()->getLocale(), $request->payroll_id])
        				 ->withSuccess(__('validation.add_success'));
    }


    /**
     * Edit staff salary info
     *
     * @param  Object  StaffSalary  $salary_history
     */
    public function edit(StaffSalary $salary_history)
    {
    	$salary_history->salary_type_shift_date = $salary_history->salary_type_shift_date > 0 ? 
                                                    date('d-m-Y', strtotime($salary_history->salary_type_shift_date)) : '';
    	
        $salary_history->salary_special_shift_date = $salary_history->salary_special_shift_date > 0 ? 
                                                        date('d-m-Y', strtotime($salary_history->salary_special_shift_date)) : '';
    	
        $salary_history->salary_type_signdate = $salary_history->salary_type_signdate > 0 ? 
                                                    date('d-m-Y', strtotime($salary_history->salary_type_signdate)) : '';

    	return $salary_history;
    }


    /**
     * Update existing staff salary info
     *
     * @param  Object  StaffSalary  $salary_history
     */
    public function update(Request $request, StaffSalary $salary_history)
    {
    	$salaryData = $request->all();
        $salaryData['salary_thanorn']                = (double)($request->salary_level_id . "." . str_replace($this->unicode_number, $this->arab_number, $request->salary_degree));
    	$salaryData['salary_type_shift_date'] = $request->salary_type_shift_date > 0 ? 
                                                date('Y-m-d', strtotime($request->salary_type_shift_date)) : null;

        $salaryData['salary_special_shift_date'] = $request->salary_special_shift_date > 0 ? 
                                                    date('Y-m-d', strtotime($request->salary_special_shift_date)) : null;

        $salaryData['salary_type_signdate'] = $request->salary_type_signdate > 0 ? 
                                                date('Y-m-d', strtotime($request->salary_type_signdate)) : null;

        $salaryData['updated_by'] = Auth::user()->id;
        $salaryData['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

        $salary_history->fill($salaryData)->save();

        StaffSalary::where('payroll_id', $request->payroll_id)->update(['highest_salary' => 0]); 
        $dd_salaryData = StaffSalary::where('payroll_id', $request->payroll_id)->orderBy('salary_thanorn', 'ASC')->first();
        $dd_salaryData->update(['highest_salary' => 1]); 



        return redirect()->route('staffs.edit', [app()->getLocale(), $request->payroll_id])
        				 ->withSuccess('Staff salary has been updated successfully.');
    }


    /**
     * Destroy existing staff salary info
     *
     * @param  Object  StaffSalary  $salary_history
     */
    public function destroy(StaffSalary $salary_history)
    {
    	$salary_history->delete();

    	return redirect()->back()->withSuccess(__('validation.delete_success'));
    }
}
