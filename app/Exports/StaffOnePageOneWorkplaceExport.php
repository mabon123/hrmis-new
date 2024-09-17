<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class StaffOnePageOneWorkplaceExport implements FromView
{
    public $pro_code;
    public $dis_code;
    public $location_code;

    //
    public function __construct($p_proCode, $p_disCode, $p_locationCode)
    {
        $this->pro_code = $p_proCode;
        $this->dis_code = $p_disCode;
        $this->location_code = $p_locationCode;
    }

    //
    public function view(): View
    {
        $staffs = DB::select("CALL sp_rptschool_inform('".$this->pro_code."', '".$this->dis_code."', '".$this->location_code."')");

        return view('admin.reports.exports.staff_in_workplace', compact('staffs'));
    }
}
