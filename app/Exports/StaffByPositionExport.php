<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class StaffByPositionExport implements FromView
{
    public $pro_code;
    public $dis_code;
    public $location_code;
    public $position_from;
    public $position_to;

    //
    public function __construct($p_proCode, $p_disCode, $p_locationCode, $p_posFrom, $p_posTo)
    {
        $this->pro_code = $p_proCode;
        $this->dis_code = $p_disCode;
        $this->location_code = $p_locationCode;
        $this->position_from = $p_posFrom;
        $this->position_to = $p_posTo;
    }
    
    //
    public function view(): View
    {
        $staffs = DB::select("CALL sp_rptstafflist_positions(
                        '".$this->pro_code."', 
                        '".$this->dis_code."', 
                        '".$this->location_code."', 
                        ".$this->position_from.", 
                        ".$this->position_to."
                    )");

        return view('admin.reports.exports.staff_by_position', compact('staffs'));
    }
}
