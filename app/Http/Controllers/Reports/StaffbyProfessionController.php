<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StaffByProfessionExport;

class StaffbyProfessionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-report-and-chart', ['only' => [
                            'generateStaffbyProfession', 
                            'showStaffbyProfession', 
                            'exportStaffbyProfessionExcel', 
                            'exportStaffbyProfessionPDF'
                        ]]);
    }

    // Staff by age report
    public function generateStaffbyProfession(Request $request)
    {
        $request->validate([
            'pro_code' => 'required',
        ], [
            'pro_code.required' => __('validation.required'),
        ]);

        $pro_code = $request->pro_code ? $request->pro_code : '99'; //Must have one
        $location_code = $request->location_code ? $request->location_code : '';
        $dis_code = $request->dis_code ? $request->dis_code : ($location_code ? substr($location_code, 0, 4) : '');

        return redirect()->route('reports.showStaffbyProfession', [app()->getLocale(), 
                $pro_code, $dis_code, $location_code
            ]);
    }

    public function showStaffbyProfession($pro_code, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptstafflist_professions(
                                '".$pro_code."',  
                                '".$dis_code."', 
                                '".$location_code."'
                            )");
        
        return view('admin.reports.staff_by_profession', compact(
                'staffs', 'pro_code', 'dis_code', 'location_code'
            ));
    }

    public function exportStaffbyProfessionExcel($pro_code, $dis_code='', $location_code='')
    {
        return Excel::download(
                new StaffByProfessionExport(
                    $pro_code, $dis_code, $location_code
                ), 
                'staff_by_profession.xlsx'
            );
    }

    public function exportStaffbyProfessionPDF($pro_code, $dis_code='', $location_code='')
    {
        $staffs = DB::select("CALL sp_rptstafflist_professions(
                                    '".$pro_code."',  
                                    '".$dis_code."', 
                                    '".$location_code."'
                                )");

        return view('admin.reports.exports.pdf.staff_by_profession', compact('staffs'));
    }
}
