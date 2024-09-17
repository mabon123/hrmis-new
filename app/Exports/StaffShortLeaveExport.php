<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Staff;

class StaffShortLeaveExport implements FromView
{
    public $pro_code;
    public $dis_code;
    public $location_code;
    public $start_date;
    public $end_date;

    //
    public function __construct($p_proCode, $p_disCode, $p_locationCode, $p_posFrom, $p_posTo)
    {
        $this->pro_code = $p_proCode;
        $this->dis_code = $p_disCode;
        $this->location_code = $p_locationCode;
        $this->start_date = $p_posFrom;
        $this->end_date = $p_posTo;
    }
    
    //
    public function view(): View
    {
        $staffs = Staff::join('hrmis_work_histories as wh', 'hrmis_staffs.payroll_id', '=', 'wh.payroll_id')
            ->join('hrmis_staff_leaves as leave', 'hrmis_staffs.payroll_id', '=', 'leave.payroll_id')
            ->select(
                'hrmis_staffs.payroll_id',
                'surname_kh',
                'name_kh',
                'is_cont_staff',
                'sex',
                'dob',
                DB::raw("DATEDIFF(leave.end_date, leave.start_date)+1 AS days"),
                'leave.start_date',
                'leave.end_date',
                'leave.description'
            )
            ->where('cur_pos', 1)
            ->where('leave.leave_type_id', 2)
            ->whereNotIn(DB::raw("IFNULL(leave.check_status_id, 0)"), [4, 6])
            ->where('wh.pro_code', $this->pro_code)
            ->when($this->dis_code != '0', function ($query) {
                $query->where(DB::raw("LEFT(wh.location_code, 4)"), $this->dis_code);
            })
            ->when($this->location_code != '0', function ($query) {
                $query->where('wh.location_code', $this->location_code);
            })
            ->whereBetween('leave.start_date', [$this->start_date, $this->end_date])
            ->whereBetween('leave.end_date', [$this->start_date, $this->end_date])
            ->orderBy('leave.start_date')
            ->get()->all();

        return view('admin.reports.exports.excel_short_leave', compact(
            'staffs'
        ));
    }
}
