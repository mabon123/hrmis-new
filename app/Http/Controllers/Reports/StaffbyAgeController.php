<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StaffByAgeExport;

class StaffbyAgeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permission:view-reports', ['only' => ['index']]);
    }

    // Staff by age report
    public function generateStaffbyAge(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
            'age_from' => 'required',
            'age_to' => 'required',
        ], [
            'age_from.required' => __('validation.required'),
            'age_to.required' => __('validation.required'),
        ]);

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $location_code = $request->location_code ? $request->location_code : '';
        $dis_code = $request->dis_code ? $request->dis_code : ($location_code ? substr($location_code, 0, 4) : '');
        $age_from = $request->age_from ? $request->age_from : 0;
        $age_to = $request->age_to ? $request->age_to : 0;

        return redirect()->route('reports.showStaffbyAge', [app()->getLocale(), 
                $pro_code, $age_from, $age_to, $dis_code, $location_code
            ]);
    }

    public function showStaffbyAge($pro_code, $age_from, $age_to, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptstafflist_ages(
                                '".$pro_code."',  
                                '".$dis_code."', 
                                '".$location_code."', 
                                ".$age_from.", 
                                ".$age_to."
                            )");
        
        return view('admin.reports.staff_by_age', compact(
                'staffs', 'pro_code', 'dis_code', 'location_code', 'age_from', 'age_to'
            ));
    }

    public function exportStaffbyAgeExcel($pro_code, $age_from, $age_to, $dis_code='', $location_code='')
    {
        return Excel::download(
                new StaffByAgeExport(
                    $pro_code, $dis_code, $location_code, $age_from, $age_to
                ), 
                'staff_by_age.xlsx'
            );
    }

    public function exportStaffbyAgePDF($pro_code, $age_from, $age_to, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptstafflist_ages(
                                    '".$pro_code."',  
                                    '".$dis_code."', 
                                    '".$location_code."', 
                                    ".$age_from.", 
                                    ".$age_to."
                                )");

        return view('admin.reports.exports.pdf.staff_by_age', compact('staffs'));
    }
}
