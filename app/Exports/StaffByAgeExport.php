<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class StaffByAgeExport implements FromView
{
    public $pro_code;
    public $dis_code;
    public $location_code;
    public $age_from;
    public $age_to;

    //
    public function __construct($p_proCode, $p_disCode, $p_locationCode, $p_ageFrom, $p_ageTo)
    {
        $this->pro_code = $p_proCode;
        $this->dis_code = $p_disCode;
        $this->location_code = $p_locationCode;
        $this->age_from = $p_ageFrom;
        $this->age_to = $p_ageTo;
    }
    
    //
    public function view(): View
    {
        $staffs = DB::select("CALL sp_rptstafflist_ages(
                        '".$this->pro_code."', 
                        '".$this->dis_code."', 
                        '".$this->location_code."', 
                        ".$this->age_from.", 
                        ".$this->age_to."
                    )");

        return view('admin.reports.exports.staff_by_age', compact('staffs'));
    }
}
