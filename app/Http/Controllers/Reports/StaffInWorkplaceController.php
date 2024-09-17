<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StaffOnePageOneWorkplaceExport;

class StaffInWorkplaceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-report-and-chart', ['only' => [
                            'generateStaffOnePageOneWorkplace', 
                            'showStaffOnePageOneWorkplace', 
                            'exportStaffOnePageOneWorkplaceExcel', 
                            'exportStaffOnePageOneWorkplacePDF'
                        ]]);
    }
    
    public function generateStaffOnePageOneWorkplace(Request $request)
    {
        $request->validate(['pro_code' => 'required']);

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $location_code = $request->location_code ? $request->location_code : '';
        $dis_code = $request->dis_code ? $request->dis_code : ($location_code ? substr($location_code, 0, 4) : '');

        return redirect()->route('reports.showStaffOnePageOneWorkplace', [app()->getLocale(), $pro_code, $dis_code, $location_code]);
    }

    public function showStaffOnePageOneWorkplace($pro_code, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptschool_inform('".$pro_code."',  '".$dis_code."', '".$location_code."')");

        return view('admin.reports.staff_in_workplace', compact('staffs', 'pro_code', 'dis_code', 'location_code'));
    }

    public function exportStaffOnePageOneWorkplaceExcel($pro_code, $dis_code='', $location_code='')
    {
        return Excel::download(new StaffOnePageOneWorkplaceExport($pro_code, $dis_code, $location_code), 
            'staffs_one_page_one_workplace.xlsx');
    }

   public function exportStaffOnePageOneWorkplacePDF($pro_code, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptschool_inform('".$pro_code."',  '".$dis_code."', '".$location_code."')");

        return view('admin.reports.exports.pdf.staff_in_workplace', compact('staffs'));
    }
}
